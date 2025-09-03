<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Amoxicillin 500mg',
                'generic_name' => 'Amoxicillin',
                'category' => 'Antibiotic',
                'sku' => 'AMO-500',
                'batch_no' => 'BATCH-A1',
                'quantity' => 120,
                'reorder_level' => 30,
                'expiry_date' => date('Y-m-d', strtotime('+6 months')),
                'unit' => 'capsule',
                'price' => 8.50,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Paracetamol 500mg',
                'generic_name' => 'Acetaminophen',
                'category' => 'Analgesic',
                'sku' => 'PAR-500',
                'batch_no' => 'BATCH-P2',
                'quantity' => 50,
                'reorder_level' => 100,
                'expiry_date' => date('Y-m-d', strtotime('+20 days')),
                'unit' => 'tablet',
                'price' => 2.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Ibuprofen 200mg',
                'generic_name' => 'Ibuprofen',
                'category' => 'NSAID',
                'sku' => 'IBU-200',
                'batch_no' => 'BATCH-I3',
                'quantity' => 200,
                'reorder_level' => 50,
                'expiry_date' => date('Y-m-d', strtotime('+90 days')),
                'unit' => 'tablet',
                'price' => 3.25,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert or upsert-like behavior based on SKU + batch
        foreach ($data as $row) {
            $existing = $this->db->table('medicines')
                ->where('sku', $row['sku'])
                ->where('batch_no', $row['batch_no'])
                ->get()->getFirstRow();
            if ($existing) {
                $this->db->table('medicines')->where('id', $existing->id)->update($row);
            } else {
                $this->db->table('medicines')->insert($row);
            }
        }
    }
}
