<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMedicineBatches extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'medicine_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'batch_no' => ['type' => 'VARCHAR', 'constraint' => 80],
            'expiry_date' => ['type' => 'DATE'],
            'stock_qty' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('medicine_id', 'medicines', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('medicine_batches', true);
    }

    public function down()
    {
        $this->forge->dropTable('medicine_batches', true);
    }
}
