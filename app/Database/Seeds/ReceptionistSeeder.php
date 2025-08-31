<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReceptionistSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'receptionist',
            'email' => 'receptionist@hms.com',
            'password' => password_hash('recep123', PASSWORD_DEFAULT),
            'first_name' => 'Receptionist',
            'last_name' => 'One',
            'role' => 'receptionist',
            'status' => 'active',
            'created_by' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $existingReceptionist = $this->db->table('users')->where('username', 'receptionist')->get()->getRow();
        
        if (!$existingReceptionist) {
            $this->db->table('users')->insert($data);
            echo "receptionist user created successfully!\n";
            echo "Username: receptionist\n";
            echo "Password: recep123\n";
        } else {
            echo "Receptionist user already exists!\n";
        }
    }
}
