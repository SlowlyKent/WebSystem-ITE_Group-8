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
                'username'   => 'receptionist',
                'email'      => 'receptionist@hms.com',
                'password'   => password_hash('recep123', PASSWORD_DEFAULT),
                'first_name' => 'Receptionist',
                'last_name'  => 'One',
                'role'       => 'receptionist',
                'status'     => 'active',
            ],
            [
                'username'   => 'dr_lisa',
                'email'      => 'lisa@hms.com',
                'password'   => password_hash('doctor123', PASSWORD_DEFAULT),
                'first_name' => 'Lalisa',
                'last_name'  => 'Manoban',
                'role'       => 'doctor',
                'status'     => 'active',
            ],
            [
                'username'   => 'dr_rose',
                'email'      => 'rose@hms.com',
                'password'   => password_hash('doctor123', PASSWORD_DEFAULT),
                'first_name' => 'Park',
                'last_name'  => 'Chaeyoung',
                'role'       => 'doctor',
                'status'     => 'active',
            ],
            [
                'username'   => 'nurse_mina',
                'email'      => 'mina@nurse.com',
                'password'   => password_hash('nurse123', PASSWORD_DEFAULT),
                'first_name' => 'Mina',
                'last_name'  => 'Lee',
                'role'       => 'nurse',
                'status'     => 'active',
            ],
        ];

        $userTable = $db->table('users');
        $userIDs = [];

        foreach ($users as $user) {
            $exists = $userTable->where('username', $user['username'])->get()->getRow();
            if (!$exists) {
                $userTable->insert($user);
                $userID = $db->insertID();
            } else {
                $userID = $exists->id;
            }
            $userIDs[$user['username']] = $userID;
        }

        // ---------- PATIENTS ----------
        $patients = [
            ['first_name' => 'Guinevere', 'last_name' => 'Baroque', 'date_of_birth' => '1990-01-01'],
            ['first_name' => 'Gusion', 'last_name' => 'Paxley', 'date_of_birth' => '1992-02-02'],
            ['first_name' => 'Park', 'last_name' => 'Jimin', 'date_of_birth' => '1988-03-03'],
        ];

        $patientTable = $db->table('patients');
        $patientIDs = [];

        foreach ($patients as $p) {
            $exists = $patientTable->where('first_name', $p['first_name'])
                                   ->where('last_name', $p['last_name'])
                                   ->get()->getRow();
            if (!$exists) {
                $p['created_at'] = date('Y-m-d H:i:s');
                $p['updated_at'] = date('Y-m-d H:i:s');
                $patientTable->insert($p);
                $patientID = $db->insertID();
            } else {
                $patientID = $exists->id;
            }
            $patientIDs[$p['first_name']] = $patientID;
        }

        // ---------- APPOINTMENTS ----------
        $appointments = [
            [
                'patient_id'       => $patientIDs['Guinevere'],
                'doctor_id'        => $userIDs['dr_lisa'],
                'appointment_date' => date('Y-m-d'),
                'appointment_time' => '09:30:00',
                'appointment_type' => 'Consultation',
                'status'           => 'Scheduled',
                'notes'            => 'Initial check-up',
                'created_by'       => $userIDs['receptionist'],
            ],
            [
                'patient_id'       => $patientIDs['Gusion'],
                'doctor_id'        => $userIDs['dr_rose'],
                'appointment_date' => date('Y-m-d'),
                'appointment_time' => '11:00:00',
                'appointment_type' => 'Check-up',
                'status'           => 'Confirmed',
                'notes'            => '',
                'created_by'       => $userIDs['receptionist'],
            ],
            [
                'patient_id'       => $patientIDs['Park'],
                'doctor_id'        => $userIDs['dr_lisa'],
                'appointment_date' => date('Y-m-d', strtotime('+2 days')),
                'appointment_time' => '14:00:00',
                'appointment_type' => 'Follow-up',
                'status'           => 'Scheduled',
                'notes'            => 'Review test results',
                'created_by'       => $userIDs['receptionist'],
            ],
        ];

        $appointmentTable = $db->table('appointments');
        foreach ($appointments as $a) {
            $a['created_at'] = date('Y-m-d H:i:s');
            $a['updated_at'] = date('Y-m-d H:i:s');
            $appointmentTable->insert($a);
        }

        echo "Seeder completed successfully.\n";
    }
}