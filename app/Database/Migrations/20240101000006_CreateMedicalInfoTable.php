<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMedicalInfoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'patient_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'blood_type' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'allergies' => [
                'type' => 'TEXT',
            ],
            'existing_condition' => [
                'type' => 'TEXT',
            ],
            'primary_physician' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('medical_info');
    }

    public function down()
    {
        $this->forge->dropTable('medical_info');
    }
}
