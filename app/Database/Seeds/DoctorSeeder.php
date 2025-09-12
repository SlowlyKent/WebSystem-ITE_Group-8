<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'dr.smith',
                'email' => 'dr.smith@hms.com',
                'password' => password_hash('doctor123', PASSWORD_DEFAULT),
                'first_name' => 'John',
                'last_name' => 'Smith',
                'role' => 'doctor',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'dr.johnson',
                'email' => 'dr.johnson@hms.com',
                'password' => password_hash('doctor123', PASSWORD_DEFAULT),
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'role' => 'doctor',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'dr.brown',
                'email' => 'dr.brown@hms.com',
                'password' => password_hash('doctor123', PASSWORD_DEFAULT),
                'first_name' => 'Michael',
                'last_name' => 'Brown',
                'role' => 'doctor',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        foreach ($data as $doctor) {
            // Check if doctor already exists
            $existingDoctor = $this->db->table('users')->where('username', $doctor['username'])->get()->getRow();
            
            if (!$existingDoctor) {
                $this->db->table('users')->insert($doctor);
                echo " Doctor {$doctor['username']} created successfully!\n";
            } else {
                echo " Doctor {$doctor['username']} already exists!\n";
            }
        }
    }
}
