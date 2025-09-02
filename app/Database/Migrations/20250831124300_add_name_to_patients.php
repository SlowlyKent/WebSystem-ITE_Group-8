<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNameToPatients extends Migration
{
    public function up()
    {
        $fields = [
            'name' => [ 'type' => 'VARCHAR', 'constraint' => 150, 'null' => true ],
        ];
        $this->forge->addColumn('patients', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('patients', 'name');
    }
}
