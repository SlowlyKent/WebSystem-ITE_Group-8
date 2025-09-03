<?php

namespace App\Controllers;

use App\Models\PrescriptionModel;
use App\Models\PrescriptionItemModel;
use App\Models\DispensationModel;
use App\Models\MedicineModel;
use App\Models\StockMovementModel;

class PrescriptionController extends BaseController
{
    private function requireLogin()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return null;
    }

    private function commonViewData(string $title): array
    {
        return [
            'title' => $title,
            'user' => [
                'id' => session()->get('id'),
                'fullName' => session()->get('fullName'),
                'role' => session()->get('role'),
                'username' => session()->get('username'),
            ],
            'pharmaStats' => $this->getPharmacyStats(),
        ];
    }

    private function getPharmacyStats(): array
    {
        $stats = [
            'medicinesInStock' => 0,
            'lowStockItems' => 0,
            'expiringSoon' => 0,
            'expired' => 0,
            'alertsTotal' => 0,
        ];

        try {
            $medicineModel = new MedicineModel();
            $sumRow = $medicineModel->selectSum('quantity')->first();
            $stats['medicinesInStock'] = (int)($sumRow['quantity'] ?? 0);

            $stats['lowStockItems'] = (int)$medicineModel
                ->where('reorder_level >', 0)
                ->where('quantity <= reorder_level', null, false)
                ->countAllResults();

            $threshold = date('Y-m-d', strtotime('+30 days'));
            $stats['expiringSoon'] = (int)$medicineModel
                ->where('expiry_date IS NOT NULL', null, false)
                ->where('expiry_date <=', $threshold)
                ->countAllResults();

            $today = date('Y-m-d');
            $stats['expired'] = (int)$medicineModel
                ->where('expiry_date IS NOT NULL', null, false)
                ->where('expiry_date <', $today)
                ->countAllResults();

            $stats['alertsTotal'] = (int)$stats['lowStockItems'] + (int)$stats['expiringSoon'] + (int)$stats['expired'];
        } catch (\Throwable $e) {
            // ignore if tables not ready
        }

        return $stats;
    }
    public function lookup()
    {
        if ($res = $this->requireLogin()) return $res;
        $data = $this->commonViewData('Patient Prescription Lookup');

        $req = service('request');
        $filters = [
            'patient' => trim((string)$req->getGet('patient')),
            'mrn' => trim((string)$req->getGet('mrn')),
            'date_from' => trim((string)$req->getGet('date_from')),
            'date_to' => trim((string)$req->getGet('date_to')),
            'status' => trim((string)$req->getGet('status')),
            'q' => trim((string)$req->getGet('q')),
        ];

        $rows = [];
        try {
            // NOTE: Patients table not defined here; using prescriptions fields + notes for simple demo
            $pres = new PrescriptionModel();
            $builder = $pres->builder()
                ->select('prescriptions.*')
                ;
            if ($filters['status'] !== '') {
                $builder->where('prescriptions.status', $filters['status']);
            }
            if ($filters['date_from']) {
                $builder->where('prescriptions.date >=', $filters['date_from']);
            }
            if ($filters['date_to']) {
                $builder->where('prescriptions.date <=', $filters['date_to']);
            }
            if ($filters['q'] !== '') {
                $q = $filters['q'];
                $builder->groupStart()
                    ->like('prescriptions.notes', $q)
                ->groupEnd();
            }
            $builder->orderBy('prescriptions.date', 'DESC');
            $rows = $builder->get(100)->getResultArray();
        } catch (\Throwable $e) {
            $rows = [];
        }

        $data['filters'] = $filters;
        $data['results'] = $rows;
        return view('pharmacy/lookup', $data);
    }

    public function view($id)
    {
        if ($res = $this->requireLogin()) return $res;
        $data = $this->commonViewData('Prescription Details');
        try {
            $pres = new PrescriptionModel();
            $itemM = new PrescriptionItemModel();

            $rx = $pres->find($id);
            $items = $itemM->where('prescription_id', $id)->findAll();

            $data['rx'] = $rx;
            $data['items'] = $items;
        } catch (\Throwable $e) {
            $data['rx'] = null;
            $data['items'] = [];
        }
        return view('pharmacy/prescription_view', $data);
    }

    public function dispense($itemId)
    {
        if ($res = $this->requireLogin()) return $res;
        $data = $this->commonViewData('Dispense Prescription Item');

        $itemM = new PrescriptionItemModel();
        $medM = new MedicineModel();
        $dispM = new DispensationModel();
        $movM = new StockMovementModel();

        $item = $itemM->find($itemId);
        $medicine = $item ? $medM->find($item['medicine_id']) : null;

        if ($this->request->getMethod() === 'post') {
            // Basic validations
            $qty = (int)$this->request->getPost('quantity_dispensed');
            $notes = trim((string)$this->request->getPost('notes'));
            if ($qty <= 0) {
                return redirect()->back()->with('error', 'Quantity must be greater than zero.');
            }
            if (!$item || !$medicine) {
                return redirect()->back()->with('error', 'Invalid prescription item.');
            }

            // Remaining allowed quantity (simple: qty_prescribed - total dispensed)
            $totalDispensed = (int)$dispM->where('prescription_item_id', $itemId)->selectSum('quantity_dispensed')->first()['quantity_dispensed'] ?? 0;
            $remaining = max(0, ((int)$item['qty_prescribed']) - $totalDispensed);
            if ($qty > $remaining) {
                return redirect()->back()->with('error', 'Quantity exceeds remaining prescribed amount.');
            }

            // Stock check
            $currentQty = (int)($medicine['quantity'] ?? 0);
            if ($qty > $currentQty) {
                return redirect()->back()->with('error', 'Insufficient stock.');
            }

            // Record dispensation
            $dispId = $dispM->insert([
                'prescription_item_id' => $itemId,
                'quantity_dispensed' => $qty,
                'dispensed_at' => date('Y-m-d H:i:s'),
                'pharmacist_id' => (int)($data['user']['id'] ?? 0),
                'reference' => 'RX-' . $item['prescription_id'],
                'notes' => $notes,
            ], true);

            // Stock movement (out)
            $movM->insert([
                'medicine_id' => $item['medicine_id'],
                'type' => 'out',
                'quantity' => $qty,
                'reference' => 'RX-' . $item['prescription_id'] . '-DISP-' . $dispId,
                'notes' => $notes,
                'batch_no' => $medicine['batch_no'] ?? null,
                'expiry_date' => $medicine['expiry_date'] ?? null,
            ]);

            // Decrement medicines.quantity
            $medM->update($item['medicine_id'], ['quantity' => $currentQty - $qty]);

            return redirect()->to(base_url('pharmacy/lookup/view/' . $item['prescription_id']))
                ->with('success', 'Dispensed successfully.');
        }

        $data['item'] = $item;
        $data['medicine'] = $medicine;
        return view('pharmacy/dispense_form', $data);
    }
}
