<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInsuranceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'patient_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'provider' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'policy' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('insurance');
    }

    public function down()
    {
        $this->forge->dropTable('insurance');
    }
}
