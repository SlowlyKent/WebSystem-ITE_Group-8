<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatients extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'name' => [ 'type' => 'VARCHAR', 'constraint' => 150 ],
            'dob' => [ 'type' => 'DATE', 'null' => true ],
            'contact' => [ 'type' => 'VARCHAR', 'constraint' => 120, 'null' => true ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('patients', true);
    }

    public function down()
    {
        $this->forge->dropTable('patients', true);
    }
}
