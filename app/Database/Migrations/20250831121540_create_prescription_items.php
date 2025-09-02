<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrescriptionItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'prescription_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'medicine_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'dosage' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'qty' => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'dispensed_qty' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('prescription_id', 'prescriptions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('medicine_id', 'medicines', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('prescription_items', true);
    }

    public function down()
    {
        $this->forge->dropTable('prescription_items', true);
    }
}
