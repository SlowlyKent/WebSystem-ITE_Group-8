<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddContactToPatients extends Migration
{
    public function up()
    {
        // Add 'contact' column if it doesn't exist
        $fields = [
            'contact' => [ 'type' => 'VARCHAR', 'constraint' => 120, 'null' => true ],
        ];
        $this->forge->addColumn('patients', $fields);
    }

    public function down()
    {
        // Drop 'contact' column
        $this->forge->dropColumn('patients', 'contact');
    }
}
