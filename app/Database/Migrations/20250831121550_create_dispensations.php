<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDispensations extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'prescription_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'dispense_date' => ['type' => 'DATETIME'],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('prescription_id', 'prescriptions', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('dispensations', true);
    }

    public function down()
    {
        $this->forge->dropTable('dispensations', true);
    }
}
