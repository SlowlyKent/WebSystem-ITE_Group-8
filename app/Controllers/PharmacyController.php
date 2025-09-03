<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MedicineModel;
use App\Models\StockMovementModel;

class PharmacyController extends Controller
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

            // Total quantity across all medicines
            $sumRow = $medicineModel->selectSum('quantity')->first();
            $stats['medicinesInStock'] = (int)($sumRow['quantity'] ?? 0);

            // Low stock: quantity <= reorder_level
            $stats['lowStockItems'] = (int)$medicineModel
                ->where('reorder_level >', 0)
                ->where('quantity <= reorder_level', null, false)
                ->countAllResults();

            // Expiring within 30 days
            $threshold = date('Y-m-d', strtotime('+30 days'));
            $stats['expiringSoon'] = (int)$medicineModel
                ->where('expiry_date IS NOT NULL', null, false)
                ->where('expiry_date <=', $threshold)
                ->countAllResults();

            // Expired as of today
            $today = date('Y-m-d');
            $stats['expired'] = (int)$medicineModel
                ->where('expiry_date IS NOT NULL', null, false)
                ->where('expiry_date <', $today)
                ->countAllResults();

            $stats['alertsTotal'] = (int)$stats['lowStockItems'] + (int)$stats['expiringSoon'] + (int)$stats['expired'];
        } catch (\Throwable $e) {
            // Tables might not exist yet; keep zeros
            log_message('debug', 'Pharmacy stats fallback: ' . $e->getMessage());
        }

        return $stats;
    }

    public function index()
    {
        if ($res = $this->requireLogin()) return $res;
        $data = $this->commonViewData('Pharmacy Dashboard');
        return view('pharmacy/index', $data);
    }

    public function inventory()
    {
        if ($res = $this->requireLogin()) return $res;
        $data = $this->commonViewData('Inventory Management');
        try {
            $medicineModel = new MedicineModel();

            // Read filters from GET
            $q = trim((string)($this->request->getGet('q') ?? ''));
            $low = $this->request->getGet('low');       // '1' to filter low stock
            $exp = $this->request->getGet('expiring');  // '1' to filter expiring within 30 days

            $builder = $medicineModel->builder();

            if ($q !== '') {
                // Search across multiple columns
                $builder->groupStart()
                    ->like('name', $q)
                    ->orLike('generic_name', $q)
                    ->orLike('sku', $q)
                    ->orLike('batch_no', $q)
                ->groupEnd();
            }

            if ($low === '1') {
                $builder->where('reorder_level >', 0);
                // Use raw condition for column-to-column comparison
                $builder->where('quantity <= reorder_level', null, false);
            }

            if ($exp === '1') {
                $threshold = date('Y-m-d', strtotime('+30 days'));
                $builder->where('expiry_date IS NOT NULL', null, false)
                        ->where('expiry_date <=', $threshold);
            }

            $builder->orderBy('name', 'ASC');
            $data['medicines'] = $builder->get()->getResultArray();

            // Preserve filter values for the view
            $data['filters'] = [
                'q' => $q,
                'low' => $low === '1',
                'expiring' => $exp === '1',
            ];
        } catch (\Throwable $e) {
            $data['medicines'] = [];
            $data['filters'] = ['q' => '', 'low' => false, 'expiring' => false];
        }
        return view('pharmacy/inventory', $data);
    }

    public function dispense()
    {
        if ($res = $this->requireLogin()) return $res;
        $data = $this->commonViewData('Dispense Medicines');
        return view('pharmacy/dispense', $data);
    }

    public function receive()
    {
        if ($res = $this->requireLogin()) return $res;
        $data = $this->commonViewData('Receive Stock');
        return view('pharmacy/receive', $data);
    }

    public function alerts()
    {
        if ($res = $this->requireLogin()) return $res;
        $data = $this->commonViewData('Low Stock & Expiry Alerts');
        try {
            $medicineModel = new MedicineModel();
            $today = date('Y-m-d');
            $threshold = date('Y-m-d', strtotime('+30 days'));

            // Low stock: quantity <= reorder_level and reorder_level > 0
            $low = $medicineModel->builder()
                ->where('reorder_level >', 0)
                ->where('quantity <= reorder_level', null, false)
                ->orderBy('name', 'ASC')
                ->get()->getResultArray();

            // Expiring soon: expiry_date <= threshold AND >= today (not expired yet)
            $expiring = $medicineModel->builder()
                ->where('expiry_date IS NOT NULL', null, false)
                ->where('expiry_date >=', $today)
                ->where('expiry_date <=', $threshold)
                ->orderBy('expiry_date', 'ASC')
                ->get()->getResultArray();

            // Expired: expiry_date < today
            $expired = $medicineModel->builder()
                ->where('expiry_date IS NOT NULL', null, false)
                ->where('expiry_date <', $today)
                ->orderBy('expiry_date', 'ASC')
                ->get()->getResultArray();

            $data['low'] = $low;
            $data['expiring'] = $expiring;
            $data['expired'] = $expired;
            $data['counts'] = [
                'low' => count($low),
                'expiring' => count($expiring),
                'expired' => count($expired),
            ];
        } catch (\Throwable $e) {
            $data['low'] = $data['expiring'] = $data['expired'] = [];
            $data['counts'] = ['low' => 0, 'expiring' => 0, 'expired' => 0];
        }
        return view('pharmacy/alerts', $data);
    }

    public function reports()
    {
        if ($res = $this->requireLogin()) return $res;
        $data = $this->commonViewData('Pharmacy Reports');

        $req = service('request');
        $filters = [
            'date_from' => trim((string)$req->getGet('date_from')),
            'date_to'   => trim((string)$req->getGet('date_to')),
            'type'      => trim((string)$req->getGet('type')), // in|out|adjust (free text)
            'q'         => trim((string)$req->getGet('q')),
            'batch_no'  => trim((string)$req->getGet('batch_no')),
            'medicine_id' => (int)$req->getGet('medicine_id'),
        ];

        $export = $req->getGet('export');

        try {
            $mov = new \App\Models\StockMovementModel();
            $builder = $mov->builder()
                ->select('stock_movements.*, medicines.name as med_name, medicines.sku as med_sku, medicines.generic_name as med_generic')
                ->join('medicines', 'medicines.id = stock_movements.medicine_id', 'left');

            if ($filters['date_from']) {
                $builder->where('stock_movements.created_at >=', $filters['date_from'] . ' 00:00:00');
            }
            if ($filters['date_to']) {
                $builder->where('stock_movements.created_at <=', $filters['date_to'] . ' 23:59:59');
            }
            if ($filters['type'] !== '') {
                $builder->where('stock_movements.type', $filters['type']);
            }
            if ($filters['batch_no'] !== '') {
                $builder->like('stock_movements.batch_no', $filters['batch_no']);
            }
            if (!empty($filters['medicine_id'])) {
                $builder->where('stock_movements.medicine_id', $filters['medicine_id']);
            }
            if ($filters['q'] !== '') {
                $q = $filters['q'];
                $builder->groupStart()
                    ->like('medicines.name', $q)
                    ->orLike('medicines.generic_name', $q)
                    ->orLike('medicines.sku', $q)
                    ->orLike('stock_movements.reference', $q)
                    ->orLike('stock_movements.notes', $q)
                ->groupEnd();
            }

            $builder->orderBy('stock_movements.created_at', 'DESC');

            // For view: limit to 200 rows to keep page light
            $rows = $builder->get(200)->getResultArray();

            if ($export === 'csv') {
                // Build CSV
                $fh = fopen('php://temp', 'r+');
                fputcsv($fh, ['Date', 'Type', 'Medicine', 'SKU', 'Quantity', 'Batch', 'Expiry', 'Reference', 'Notes']);
                foreach ($rows as $r) {
                    fputcsv($fh, [
                        isset($r['created_at']) ? date('Y-m-d H:i', strtotime($r['created_at'])) : '',
                        $r['type'] ?? '',
                        $r['med_name'] ?? '',
                        $r['med_sku'] ?? '',
                        $r['quantity'] ?? '',
                        $r['batch_no'] ?? '',
                        !empty($r['expiry_date']) ? date('Y-m-d', strtotime($r['expiry_date'])) : '',
                        $r['reference'] ?? '',
                        $r['notes'] ?? '',
                    ]);
                }
                rewind($fh);
                $csv = stream_get_contents($fh);
                fclose($fh);

                $filename = 'pharmacy_reports_' . date('Ymd_His') . '.csv';
                return $this->response
                    ->setHeader('Content-Type', 'text/csv')
                    ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->setBody($csv);
            }

            // For medicine select options
            $medModel = new MedicineModel();
            $medicines = $medModel->select('id, name, sku')->orderBy('name', 'ASC')->findAll(500);

            $data['filters'] = $filters;
            $data['movements'] = $rows;
            $data['medicines'] = $medicines;
        } catch (\Throwable $e) {
            $data['filters'] = $filters;
            $data['movements'] = [];
            $data['medicines'] = [];
        }

        return view('pharmacy/reports', $data);
    }

    // Medicines CRUD
    public function createMedicine()
    {
        if ($res = $this->requireLogin()) return $res;
        $data = $this->commonViewData('Add Medicine');
        $data['medicine'] = null;
        return view('pharmacy/medicine_form', $data);
    }

    public function storeMedicine()
    {
        if ($res = $this->requireLogin()) return $res;
        $medicineModel = new MedicineModel();

        $rules = [
            'name' => 'required|min_length[2]',
            'sku' => 'permit_empty|max_length[100]',
            'batch_no' => 'permit_empty|max_length[100]',
            'quantity' => 'required|integer',
            'reorder_level' => 'permit_empty|integer',
            'expiry_date' => 'permit_empty|valid_date',
            'price' => 'permit_empty|decimal'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'generic_name' => $this->request->getPost('generic_name'),
            'category' => $this->request->getPost('category'),
            'sku' => $this->request->getPost('sku'),
            'batch_no' => $this->request->getPost('batch_no'),
            'quantity' => (int)$this->request->getPost('quantity'),
            'reorder_level' => (int)$this->request->getPost('reorder_level'),
            'expiry_date' => $this->request->getPost('expiry_date') ?: null,
            'unit' => $this->request->getPost('unit'),
            'price' => $this->request->getPost('price') ?: 0,
        ];

        $medicineModel->insert($data);
        session()->setFlashdata('success', 'Medicine created successfully');
        return redirect()->to('/pharmacy/inventory');
    }

    public function editMedicine($id)
    {
        if ($res = $this->requireLogin()) return $res;
        $medicineModel = new MedicineModel();
        $medicine = $medicineModel->find($id);
        if (!$medicine) {
            session()->setFlashdata('error', 'Medicine not found');
            return redirect()->to('/pharmacy/inventory');
        }
        $data = $this->commonViewData('Edit Medicine');
        $data['medicine'] = $medicine;
        return view('pharmacy/medicine_form', $data);
    }

    public function updateMedicine($id)
    {
        if ($res = $this->requireLogin()) return $res;
        $medicineModel = new MedicineModel();

        $rules = [
            'name' => 'required|min_length[2]',
            'sku' => 'permit_empty|max_length[100]',
            'batch_no' => 'permit_empty|max_length[100]',
            'quantity' => 'required|integer',
            'reorder_level' => 'permit_empty|integer',
            'expiry_date' => 'permit_empty|valid_date',
            'price' => 'permit_empty|decimal'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'generic_name' => $this->request->getPost('generic_name'),
            'category' => $this->request->getPost('category'),
            'sku' => $this->request->getPost('sku'),
            'batch_no' => $this->request->getPost('batch_no'),
            'quantity' => (int)$this->request->getPost('quantity'),
            'reorder_level' => (int)$this->request->getPost('reorder_level'),
            'expiry_date' => $this->request->getPost('expiry_date') ?: null,
            'unit' => $this->request->getPost('unit'),
            'price' => $this->request->getPost('price') ?: 0,
        ];

        $medicineModel->update($id, $data);
        session()->setFlashdata('success', 'Medicine updated successfully');
        return redirect()->to('/pharmacy/inventory');
    }

    public function deleteMedicine($id)
    {
        if ($res = $this->requireLogin()) return $res;
        $medicineModel = new MedicineModel();
        $medicineModel->delete($id);
        session()->setFlashdata('success', 'Medicine deleted successfully');
        return redirect()->to('/pharmacy/inventory');
    }
}
