<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PharmacySeeder extends Seeder
{
    public function run()
    {
        // Patients (support two schemas)
        $patientFields = $this->db->getFieldNames('patients');
        if (in_array('patient_id', $patientFields)) {
            // Expanded schema with required fields and unique patient_id
            $now = date('Y-m-d H:i:s');
            $this->db->table('patients')->insertBatch([
                [
                    'patient_id' => 'P0001',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'date_of_birth' => '1990-05-12',
                    'gender' => 'male',
                    'phone' => '09171234567',
                    'email' => null,
                    'address' => null,
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'patient_id' => 'P0002',
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'date_of_birth' => '1985-11-03',
                    'gender' => 'female',
                    'phone' => '09179876543',
                    'email' => null,
                    'address' => null,
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        } else {
            // Minimal schema
            $this->db->table('patients')->insertBatch([
                ['name' => 'John Doe', 'dob' => '1990-05-12', 'contact' => '09171234567'],
                ['name' => 'Jane Smith', 'dob' => '1985-11-03', 'contact' => '09179876543'],
            ]);
        }

        // Medicines
        $this->db->table('medicines')->insertBatch([
            ['name' => 'Paracetamol', 'form' => 'Tablet', 'strength' => '500mg', 'reorder_level' => 20],
            ['name' => 'Amoxicillin', 'form' => 'Capsule', 'strength' => '500mg', 'reorder_level' => 30],
            ['name' => 'Cough Syrup', 'form' => 'Syrup', 'strength' => '100ml', 'reorder_level' => 10],
        ]);

        // Batches (assume inserted IDs 1..n)
        $this->db->table('medicine_batches')->insertBatch([
            ['medicine_id' => 1, 'batch_no' => 'PCT-2401', 'expiry_date' => date('Y-m-d', strtotime('+12 months')), 'stock_qty' => 200],
            ['medicine_id' => 2, 'batch_no' => 'AMX-2402', 'expiry_date' => date('Y-m-d', strtotime('+16 months')), 'stock_qty' => 150],
            ['medicine_id' => 3, 'batch_no' => 'CFS-2403', 'expiry_date' => date('Y-m-d', strtotime('+1 month')), 'stock_qty' => 25],
        ]);

        // Prescriptions
        $this->db->table('prescriptions')->insertBatch([
            ['patient_id' => 1, 'rx_no' => 'RX-1001', 'rx_date' => date('Y-m-d'), 'status' => 'Pending'],
            ['patient_id' => 2, 'rx_no' => 'RX-1002', 'rx_date' => date('Y-m-d', strtotime('-1 day')), 'status' => 'Pending'],
        ]);

        // Prescription Items
        $this->db->table('prescription_items')->insertBatch([
            ['prescription_id' => 1, 'medicine_id' => 1, 'dosage' => '1 tab q6h PRN', 'qty' => 10, 'dispensed_qty' => 0],
            ['prescription_id' => 1, 'medicine_id' => 3, 'dosage' => '10ml q8h', 'qty' => 1, 'dispensed_qty' => 0],
            ['prescription_id' => 2, 'medicine_id' => 2, 'dosage' => '1 cap TID x7 days', 'qty' => 21, 'dispensed_qty' => 0],
        ]);
    }
}
