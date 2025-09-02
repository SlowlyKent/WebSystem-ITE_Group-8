<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDobToPatients extends Migration
{
    public function up()
    {
        // Add 'dob' column if it doesn't exist
        $fields = [
            'dob' => [ 'type' => 'DATE', 'null' => true ],
        ];
        $this->forge->addColumn('patients', $fields);
    }

    public function down()
    {
        // Drop 'dob' column
        $this->forge->dropColumn('patients', 'dob');
    }
}
