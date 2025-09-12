<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrescriptionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'patient_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'doctor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'patient_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'medication_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'dosage' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'frequency' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'duration' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'priority' => [
                'type'       => 'ENUM',
                'constraint' => ['low', 'medium', 'high', 'urgent'],
                'default'    => 'medium',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'completed', 'cancelled'],
                'default'    => 'active',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'prescribed_date' => [
                'type'    => 'DATETIME',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'default' => 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('patient_id');
        $this->forge->addKey('doctor_id');
        
        // Add foreign key constraint
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('prescriptions');

        // Insert sample data
        $data = [
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'patient_name' => 'John Doe',
                'medication_name' => 'Amoxicillin',
                'dosage' => '500mg',
                'frequency' => '3 times daily',
                'duration' => '7 days',
                'priority' => 'medium',
                'status' => 'active',
                'notes' => 'Take with food to avoid stomach upset',
                'prescribed_date' => '2024-01-20 10:30:00'
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 1,
                'patient_name' => 'Jane Smith',
                'medication_name' => 'Lisinopril',
                'dosage' => '10mg',
                'frequency' => 'Once daily',
                'duration' => '30 days',
                'priority' => 'high',
                'status' => 'active',
                'notes' => 'Monitor blood pressure regularly',
                'prescribed_date' => '2024-01-19 14:15:00'
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 1,
                'patient_name' => 'Mike Johnson',
                'medication_name' => 'Ibuprofen',
                'dosage' => '400mg',
                'frequency' => 'As needed',
                'duration' => '14 days',
                'priority' => 'low',
                'status' => 'completed',
                'notes' => 'For pain relief, maximum 3 times per day',
                'prescribed_date' => '2024-01-18 09:45:00'
            ]
        ];

        $this->db->table('prescriptions')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('prescriptions');
    }
}
