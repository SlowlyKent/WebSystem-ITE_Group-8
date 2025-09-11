<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReceptionistSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // ---------- USERS ----------
        $users = [  
            [
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
            ],
             [
                'username' =>'Jennie',
                'email' => 'jenniekim@hms.com',
                'password' => password_hash('recep123', PASSWORD_DEFAULT),
                'first_name' => 'Kim',
                'last_name' => 'Jennie',
                'role' => 'patient',
                'status' => 'active',
                'created_by' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'dr_Lisa',
                'email' => 'Lisa@hms.com',
                'password' => password_hash('doctor123', PASSWORD_DEFAULT),
                'first_name' => 'Lalisa',
                'last_name' => 'Manoban',
                'role' => 'doctor',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'dr_Rose',
                'email' => 'Rose@hms.com',
                'password' => password_hash('doctor123', PASSWORD_DEFAULT),
                'first_name' => 'Park',
                'last_name' => 'Chaeyoung',
                'role' => 'doctor',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $userTable = $db->table('users');
        foreach ($users as $user) {
            $exists = $userTable->where('username', $user['username'])->get()->getRow();
            if (!$exists) {
                $userTable->insert($user);
                echo $user['username'] . " created.\n";
            } else {
                echo $user['username'] . " already exists.\n";
            }
        }

        // ---------- PATIENTS ----------
        $patients = [
            ['first_name' => 'Kim', 'last_name' => 'Jennie', 'date_of_birth' => '1990-06-10', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];

        $patientTable = $db->table('patients');
        foreach ($patients as $p) {
            $patientTable->insert($p);
        }
        echo "Patients seeded successfully!\n";

        // ---------- APPOINTMENTS ----------
        $appointments = [
            [
                'patient_id' => 2,
                'doctor_id' => 3, 
                'appointment_date' => date('Y-m-d'),
                'appointment_time' => '09:30:00',
                'appointment_type' => 'Consultation',
                'status' => 'Scheduled',
                'notes' => 'Initial check-up',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 4, 
                'appointment_date' => date('Y-m-d'),
                'appointment_time' => '11:00:00',
                'appointment_type' => 'Check-up',
                'status' => 'Confirmed',
                'notes' => '',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 3,
                'appointment_date' => date('Y-m-d', strtotime('+2 days')),
                'appointment_time' => '14:00:00',
                'appointment_type' => 'Follow-up',
                'status' => 'Scheduled',
                'notes' => 'Review test results',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $appointmentTable = $db->table('appointments');
        foreach ($appointments as $a) {
            $appointmentTable->insert($a);
        }
        echo "Appointments seeded successfully!\n";
    }
}
