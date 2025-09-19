<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NurseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'nurse.mary',
                'email' => 'nurse.mary@hms.com',
                'password' => password_hash('nurse123', PASSWORD_DEFAULT),
                'first_name' => 'Mary',
                'last_name' => 'Williams',
                'role' => 'nurse',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'nurse.jane',
                'email' => 'nurse.jane@hms.com',
                'password' => password_hash('nurse123', PASSWORD_DEFAULT),
                'first_name' => 'Jane',
                'last_name' => 'Davis',
                'role' => 'nurse',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'nurse.lisa',
                'email' => 'nurse.lisa@hms.com',
                'password' => password_hash('nurse123', PASSWORD_DEFAULT),
                'first_name' => 'Lisa',
                'last_name' => 'Anderson',
                'role' => 'nurse',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        foreach ($data as $nurse) {
            // Check if nurse already exists
            $existingNurse = $this->db->table('users')->where('username', $nurse['username'])->get()->getRow();
            
            if (!$existingNurse) {
                $this->db->table('users')->insert($nurse);
                echo " Nurse {$nurse['username']} created successfully!\n";
            } else {
                echo " Nurse {$nurse['username']} already exists!\n";
            }
        }
    }
}
