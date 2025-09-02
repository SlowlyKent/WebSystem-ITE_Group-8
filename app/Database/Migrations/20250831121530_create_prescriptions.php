<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrescriptions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'patient_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'rx_no' => ['type' => 'VARCHAR', 'constraint' => 60, 'unique' => true],
            'rx_date' => ['type' => 'DATE'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'Pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('prescriptions', true);
    }

    public function down()
    {
        $this->forge->dropTable('prescriptions', true);
    }
}
