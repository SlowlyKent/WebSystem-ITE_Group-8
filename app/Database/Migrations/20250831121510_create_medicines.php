<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMedicines extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'form' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true], // tablet, syrup, etc.
            'strength' => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'reorder_level' => ['type' => 'INT', 'constraint' => 11, 'default' => 10],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('medicines', true);
    }

    public function down()
    {
        $this->forge->dropTable('medicines', true);
    }
}
