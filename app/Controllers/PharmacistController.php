<?php
namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MedicineModel;
use App\Models\MedicineBatchModel;
use App\Models\PrescriptionModel;
use App\Models\PrescriptionItemModel;
use App\Models\DispensationModel;
use Config\Database;

class PharmacistController extends BaseController
{
    /**
     * Dashboard landing
     */
    public function index()
    {
        $db = Database::connect();
        $batches = new MedicineBatchModel();
        $meds = new MedicineModel();
        $pres = new PrescriptionModel();

        // Total items in stock (sum of all batch quantities)
        $inStock = (int) ($batches->selectSum('stock_qty')->get()->getRow()->stock_qty ?? 0);

        // Low stock items: handle DBs without m.reorder_level by using default threshold
        $hasReorder = in_array('reorder_level', $db->getFieldNames('medicines'));
        if ($hasReorder) {
            try {
                $lowStock = $db->table('medicines m')
                    ->join('medicine_batches b', 'b.medicine_id = m.id', 'left')
                    ->select('m.id')
                    ->selectSum('b.stock_qty', 'total_stock')
                    ->groupBy('m.id')
                    ->having('COALESCE(SUM(b.stock_qty),0) <= m.reorder_level')
                    ->get()->getResult();
                $lowStockCount = is_array($lowStock) ? count($lowStock) : 0;
            } catch (\Throwable $e) {
                // Fallback to default threshold if query fails for any reason
                $defaultThreshold = 10;
                $lowStock = $db->table('medicines m')
                    ->join('medicine_batches b', 'b.medicine_id = m.id', 'left')
                    ->select('m.id')
                    ->selectSum('b.stock_qty', 'total_stock')
                    ->groupBy('m.id')
                    ->having('COALESCE(SUM(b.stock_qty),0) <=', $defaultThreshold)
                    ->get()->getResult();
                $lowStockCount = is_array($lowStock) ? count($lowStock) : 0;
            }
        } else {
            $defaultThreshold = 10;
            $lowStock = $db->table('medicines m')
                ->join('medicine_batches b', 'b.medicine_id = m.id', 'left')
                ->select('m.id')
                ->selectSum('b.stock_qty', 'total_stock')
                ->groupBy('m.id')
                ->having('COALESCE(SUM(b.stock_qty),0) <=', $defaultThreshold)
                ->get()->getResult();
            $lowStockCount = is_array($lowStock) ? count($lowStock) : 0;
        }

        // Expiring soon: batches expiring in next 30 days with stock
        $expiringSoon = $batches
            ->where('expiry_date <=', date('Y-m-d', strtotime('+30 days')))
            ->where('stock_qty >', 0)
            ->countAllResults();

        // Pending prescriptions
        $pending = $pres->where('status', 'Pending')
            ->orderBy('rx_date', 'DESC')
            ->limit(5)
            ->find();

        $data = [
            'title' => 'Pharmacist Dashboard',
            'stats' => [
                'in_stock' => $inStock,
                'low_stock' => $lowStockCount,
                'expiring_soon' => $expiringSoon,
            ],
            'pending_prescriptions' => array_map(function($p){
                return [
                    'id' => $p['rx_no'] ?? ('RX-' . $p['id']),
                    'patient' => (string) ($p['patient_id'] ?? ''),
                    'date' => $p['rx_date'] ?? '',
                    'status' => $p['status'] ?? 'Pending',
                ];
            }, $pending ?? []),
        ];

        return view('pharmacist/dashboard', $data);
    }

    /** Inventory Management */
    public function inventory()
    {
        $db = Database::connect();
        // Aggregate stock per medicine and show nearest expiry
        $rows = $db->query(
            'SELECT m.id, m.name, m.form, m.strength,
                    COALESCE(SUM(b.stock_qty),0) AS stock,
                    MIN(b.expiry_date) AS nearest_expiry
             FROM medicines m
             LEFT JOIN medicine_batches b ON b.medicine_id = m.id
             GROUP BY m.id, m.name, m.form, m.strength
             ORDER BY m.name'
        )->getResultArray();

        $items = array_map(fn($r) => [
            'name' => trim($r['name'] . ' ' . ($r['strength'] ?? '')),
            'stock' => (int) $r['stock'],
            'expires' => $r['nearest_expiry'] ?? '—',
        ], $rows);

        return view('pharmacist/inventory', [
            'title' => 'Inventory Management',
            'items' => $items,
        ]);
    }

    /** Low Stock & Expiry Alerts */
    public function alerts()
    {
        $db = Database::connect();
        // Low stock list, guard missing reorder_level
        $hasReorder = in_array('reorder_level', $db->getFieldNames('medicines'));
        if ($hasReorder) {
            try {
                $lowRows = $db->query(
                    'SELECT m.name, m.strength, m.reorder_level, COALESCE(SUM(b.stock_qty),0) AS total_stock
                     FROM medicines m
                     LEFT JOIN medicine_batches b ON b.medicine_id = m.id
                     GROUP BY m.id, m.name, m.strength, m.reorder_level
                     HAVING total_stock <= m.reorder_level
                     ORDER BY total_stock ASC'
                )->getResultArray();
            } catch (\Throwable $e) {
                $defaultThreshold = 10;
                $lowRows = $db->query(
                    'SELECT m.name, m.strength, COALESCE(SUM(b.stock_qty),0) AS total_stock
                     FROM medicines m
                     LEFT JOIN medicine_batches b ON b.medicine_id = m.id
                     GROUP BY m.id, m.name, m.strength
                     HAVING total_stock <= ?
                     ORDER BY total_stock ASC',
                    [$defaultThreshold]
                )->getResultArray();
            }
        } else {
            $defaultThreshold = 10;
            $lowRows = $db->query(
                'SELECT m.name, m.strength, COALESCE(SUM(b.stock_qty),0) AS total_stock
                 FROM medicines m
                 LEFT JOIN medicine_batches b ON b.medicine_id = m.id
                 GROUP BY m.id, m.name, m.strength
                 HAVING total_stock <= ?
                 ORDER BY total_stock ASC',
                [$defaultThreshold]
            )->getResultArray();
        }
        $lowStock = array_map(fn($r) => [
            'name' => trim(($r['name'] ?? '') . ' ' . ($r['strength'] ?? '')),
            'stock' => (int) ($r['total_stock'] ?? 0),
        ], $lowRows);

        // Expiring within 30 days
        $expRows = $db->query(
            'SELECT m.name, m.strength, b.expiry_date
             FROM medicine_batches b
             JOIN medicines m ON m.id = b.medicine_id
             WHERE b.expiry_date <= ? AND b.stock_qty > 0
             ORDER BY b.expiry_date ASC',
             [date('Y-m-d', strtotime('+30 days'))]
        )->getResultArray();
        $expiring = array_map(fn($r) => [
            'name' => trim($r['name'] . ' ' . ($r['strength'] ?? '')),
            'expires' => $r['expiry_date'],
        ], $expRows);

        return view('pharmacist/alerts', [
            'title' => 'Low Stock & Expiry Alerts',
            'lowStock' => $lowStock,
            'expiring' => $expiring,
        ]);
    }

    /** Reports */
    public function reports()
    {
        $db = Database::connect();
        $today = date('Y-m-d');
        $week = date('Y-m-d', strtotime('-6 days'));

        $dispensedToday = (int) $db->table('dispensations')
            ->where('DATE(dispense_date)', $today)
            ->countAllResults();

        $dispensedWeek = (int) $db->table('dispensations')
            ->where('DATE(dispense_date) >=', $week)
            ->countAllResults();

        $top = $db->query(
            'SELECT m.name, m.strength, SUM(pi.dispensed_qty) AS qty
             FROM prescription_items pi
             JOIN medicines m ON m.id = pi.medicine_id
             GROUP BY m.id, m.name, m.strength
             ORDER BY qty DESC
             LIMIT 10'
        )->getResultArray();

        $report = [
            'dispensed_today' => $dispensedToday,
            'dispensed_week' => $dispensedWeek,
            'top_medicines' => array_map(fn($r) => [
                'name' => trim($r['name'] . ' ' . ($r['strength'] ?? '')),
                'qty' => (int) $r['qty'],
            ], $top),
        ];

        return view('pharmacist/reports', [ 'title' => 'Reports', 'report' => $report ]);
    }

    /** Patient Prescription Lookup */
    public function lookup()
    {
        $db = Database::connect();
        $q = trim((string)$this->request->getGet('q'));
        $results = [];
        if ($q !== '') {
            $builder = $db->table('prescriptions p')
                ->select('p.rx_no, p.rx_date, p.status, pa.name AS patient')
                ->join('patients pa', 'pa.id = p.patient_id', 'left')
                ->like('p.rx_no', $q)
                ->orLike('pa.name', $q)
                ->orderBy('p.rx_date', 'DESC')
                ->limit(50);
            $results = array_map(fn($r) => [
                'rx' => $r['rx_no'],
                'patient' => $r['patient'] ?? '—',
                'date' => $r['rx_date'],
                'status' => $r['status'],
            ], $builder->get()->getResultArray());
        }
        return view('pharmacist/lookup', [ 'title' => 'Patient Prescription Lookup', 'q' => $q, 'results' => $results ]);
    }

    /** Dispense Medicines */
    public function dispense()
    {
        $message = null;
        if ($this->request->getMethod() === 'post') {
            $rxNo = trim((string) $this->request->getPost('rx'));
            $medQuery = trim((string) $this->request->getPost('med'));
            $qty = max(0, (int) $this->request->getPost('qty'));
            if ($rxNo !== '' && $medQuery !== '' && $qty > 0) {
                $db = Database::connect();
                $medModel = new MedicineModel();
                $batchModel = new MedicineBatchModel();
                $presModel = new PrescriptionModel();
                $itemModel = new PrescriptionItemModel();
                $dispModel = new DispensationModel();

                // Find prescription and medicine
                $pres = $presModel->where('rx_no', $rxNo)->first();
                $med = $medModel->like('name', $medQuery)->first();

                if (!$pres || !$med) {
                    $message = 'Prescription or medicine not found.';
                } else {
                    $db->transStart();
                    // FIFO batches
                    $remaining = $qty;
                    $batches = $batchModel->where('medicine_id', $med['id'])
                        ->where('stock_qty >', 0)
                        ->orderBy('expiry_date', 'ASC')
                        ->findAll();
                    foreach ($batches as $b) {
                        if ($remaining <= 0) break;
                        $use = min($remaining, (int)$b['stock_qty']);
                        if ($use <= 0) continue;
                        $batchModel->update($b['id'], ['stock_qty' => (int)$b['stock_qty'] - $use]);
                        $remaining -= $use;
                    }

                    // Update prescription item dispensed_qty (first matching medicine)
                    $pi = $itemModel->where('prescription_id', $pres['id'])
                        ->where('medicine_id', $med['id'])
                        ->first();
                    if ($pi) {
                        $itemModel->update($pi['id'], ['dispensed_qty' => (int)$pi['dispensed_qty'] + ($qty - $remaining)]);
                    }

                    // If all items for prescription are fully dispensed, mark as Completed
                    $incomplete = $itemModel->where('prescription_id', $pres['id'])
                        ->groupStart()->where('dispensed_qty < qty')->groupEnd()
                        ->countAllResults();
                    if ($incomplete === 0) {
                        $presModel->update($pres['id'], ['status' => 'Completed']);
                    }

                    // Record dispensation
                    $dispModel->insert([
                        'prescription_id' => $pres['id'],
                        'dispense_date' => date('Y-m-d H:i:s'),
                        'notes' => 'Auto-recorded via dashboard',
                    ]);

                    $db->transComplete();
                    if ($db->transStatus() === false) {
                        $message = 'Failed to dispense due to a database error.';
                    } else {
                        $dispensed = $qty - $remaining;
                        $message = $dispensed > 0
                            ? ('Dispensed ' . $dispensed . ' unit(s) of ' . esc($med['name']) . ' for ' . esc($rxNo) . '.')
                            : 'Insufficient stock to dispense.';
                    }
                }
            } else {
                $message = 'Please fill all fields correctly.';
            }
        }
        return view('pharmacist/dispense', [ 'title' => 'Dispense Medicines', 'message' => $message ]);
    }
}
