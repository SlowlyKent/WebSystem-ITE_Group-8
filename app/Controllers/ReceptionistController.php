<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AppointmentModel;
use App\Models\DoctorModel;

class ReceptionistController extends Controller
{
    public function index()
    {
        $session = session();

        if (! $session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Only allow receptionist
        if ($session->get('role') !== 'receptionist') {
            throw \CodeIgniter\Exceptions\PageForbiddenException::forPageForbidden();
        }

        $session = session();
        $appointmentModel = new \App\Models\AppointmentModel();

        $todayAppointments    = $appointmentModel->getTodaysAppointmentsWithDetails();
        $upcomingAppointments = $appointmentModel->getUpcomingAppointmentsWithDetails();
        $finishedAppointments = $appointmentModel->getCompletedAppointmentsWithDetails();

        $data = [
            'title' => 'Receptionist Dashboard',
            'user'  => [
                'fullName' => $session->get('fullName'),
                'role'     => $session->get('role'),
            ],
            'stats' => [
                'totalPatients'    => 10,
                'totalAppointments'=> count($todayAppointments),
                'pendingPayments'  => 0,
            ],
            'billingSummary' => [
                'paid'    => 25,
                'unpaid'  => 10,
                'pending' => 5,
            ],
            'todayAppointments'    => $todayAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'finishedAppointments' => $finishedAppointments,
        ];

        // Data for dashboard
        $data = [
            'title' => 'Receptionist Dashboard',
            'user'  => [
                'fullName' => $session->get('fullName'),
                'role'     => $session->get('role'),
            ],
            'stats' => [
                'totalPatients'    => 10,
                'totalAppointments'=> count($todayAppointments),
                'pendingPayments'  => 0,
            ],
            'billingSummary' => [
                'paid'    => 25,
                'unpaid'  => 10,
                'pending' => 5,
            ],
            'report' => [
                'totalPatients' => 120,
                'paidBills'     => 85,
                'pendingBills'  => 25,
                'overdue'       => 10,
            ],
            'todayAppointments'    => $todayAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'finishedAppointments' => $finishedAppointments,
            ];

            return view('role_dashboard/receptionist/dashboard', $data);
        }

        public function patientregistration()
        {
            $session = session();

            $data = [
                'title' => 'Patient Registration',
                'user' => [
                    'fullName' => $session->get('fullName'),
                    'role'     => $session->get('role'),
                ]
            ];

            return view('role_dashboard/receptionist/patientregistration', $data);
        }

        public function appointmentbooking()
        {
            $session = session();

            if (! $session->get('isLoggedIn')) {
                return redirect()->to('/login');
            }

            if ($session->get('role') !== 'receptionist') {
                throw \CodeIgniter\Exceptions\PageForbiddenException::forPageForbidden();
            }

            $appointmentModel = new \App\Models\AppointmentModel();
            $doctorModel = new \App\Models\DoctorModel();

            $user = [
            'fullName' => $session->get('fullName'),
            'role' => $session->get('role'),
            ];

            $data = [
                'title'               => 'Appointment Booking',
                'todayAppointments'   => $appointmentModel->getTodaysAppointmentsWithDetails(),
                'upcomingAppointments'=> $appointmentModel->getUpcomingAppointmentsWithDetails(),
                'finishedAppointments'=> $appointmentModel->getCompletedAppointmentsWithDetails(),
                'doctors'             => $doctorModel->getAllDoctors(),
                'user'                => $user,
            ];

            return view('role_dashboard/receptionist/appointmentbooking', $data);
        }

        public function saveAppointment()
        {
            $appointmentModel = new AppointmentModel();
            //check for conflicts
            $userModel        = new \App\Models\UserModel();
            $patientModel     = new \App\Models\PatientModel();

            $doctorId   = $this->request->getPost('doctor_id');
            $date       = $this->request->getPost('date');
            $time       = $this->request->getPost('time');

            // 🔎 Check if this doctor already has an appointment at the same date & time
            $conflicts = $appointmentModel
                ->where('doctor_id', $doctorId)
                ->where('appointment_date', $date)
                ->where('appointment_time', $time)
                ->findAll();

            if ($conflicts) {
                // Get doctor info
                $doctor = $userModel->find($doctorId);

                // Build conflict details
                $details = [];
                foreach ($conflicts as $c) {
                    $patient = $patientModel->find($c['patient_id']);
                    $details[] = [
                        'patient' => $patient ? $patient['first_name'].' '.$patient['last_name'] : 'Unknown Patient',
                        'time'    => $c['appointment_time'],
                        'date'    => $c['appointment_date'],
                    ];
                }

            // Flash data with details
            session()->setFlashdata('error', "Schedule not available. Dr. {$doctor['first_name']} {$doctor['last_name']} is already booked at this time.");
            session()->setFlashdata('conflicts', $details);

            return redirect()->back()->withInput();
        }

        // No conflicts, proceed to save
        $data = [
            'patient_id'       => $this->request->getPost('patient_id'),
            'doctor_id'        => $this->request->getPost('doctor_id'),
            'appointment_date' => $this->request->getPost('date'),
            'appointment_time' => $this->request->getPost('time'),
            'appointment_type' => $this->request->getPost('appointment_type'),
            'status'           => 'Scheduled',
            'notes'            => $this->request->getPost('notes'),
            'created_by'       => session()->get('userId'),
        ];

        if ($appointmentModel->save($data)) {
            return redirect()->to('role_dashboard/receptionist/appointmentbooking')->with('success', 'Appointment booked successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $appointmentModel->errors());
        }
    }

    public function patientsearch_lookup()
    {
        $session = session();

        // For now, return dummy patient data
        $patients = [
            ['id' => 1, 'fullName' => 'Kim Jennie', 'contact' => '09123456789', 'dob' => '1990-05-10'],
            ['id' => 2, 'fullName' => 'Kim Jisoo', 'contact' => '09876543210', 'dob' => '1985-08-22'],
            ['id' => 2, 'fullName' => 'Park Chaeyoung', 'contact' => '09876543980', 'dob' => '1985-04-28'],
            ['id' => 2, 'fullName' => 'La Lisa Manoban', 'contact' => '09876541376', 'dob' => '1985-11-12'],
        ];

        $data = [
            'title' => 'Patient Search & Lookup',
            'user' => [
                'fullName' => $session->get('fullName'),
                'role'     => $session->get('role'),
            ],
            'patients' => $patients
        ];

        return view('role_dashboard/receptionist/patientsearch_lookup', $data);
    }

    public function scheduleviewer()
    {
        $session = session();

        // Dummy schedule data
        $doctorSchedule = [
            ['name' => 'Dr. Park', 'specialization' => 'Cardiology', 'days' => 'Mon, Wed, Fri'],
            ['name' => 'Dr. Kim', 'specialization' => 'Pediatrics', 'days' => 'Tue, Thu'],
            ['name' => 'Dr. Liu', 'specialization' => 'Psychiatrist', 'days' => 'Fri, Sat'],
        ];

        $nurseSchedule = [
            ['name' => 'Nurse Chua', 'shift' => 'Morning', 'days' => 'Mon-Fri'],
            ['name' => 'Nurse Xie', 'shift' => 'Night', 'days' => 'Mon-Sat'],
            ['name' => 'Nurse Zhou', 'shift' => 'Night', 'days' => 'Sat-Mon'],
        ];

        $data = [
            'title' => 'Doctor/Nurse Schedule Viewer',
            'user' => [
                'fullName' => $session->get('fullName'),
                'role'     => $session->get('role'),
            ],
            'doctorSchedule' => $doctorSchedule,
            'nurseSchedule'  => $nurseSchedule
        ];

        return view('role_dashboard/receptionist/scheduleviewer', $data);
    }

    public function billing()
    {
        $session = session();

        $data = [
            'title' => 'Billing & Payments',
            'user' => [
                'fullName' => $session->get('fullName'),
                'role'     => $session->get('role'),
            ],

            'pastDue' => [
                ['name' => 'Kim Jennie', 'due' => '2025-09-01'],
            ],
            'unpaid' => [
                ['name' => 'Min Yoongi', 'due' => '2025-09-20'],
            ],
            'pending' => [
                ['name' => 'Lisa Manoban', 'due' => '2025-09-15'],
            ],
            'paid' => [
                ['name' => 'Roseanne Park', 'date' => '2025-09-05'],
            ],
        ];

        return view('role_dashboard/receptionist/billing', $data);
    }

    public function reports()
    {
        $session = session();

        $data = [
            'title' => 'Reports',
            'user' => [
                'fullName' => $session->get('fullName'),
                'role'     => $session->get('role'),
            ],

            // --- Widgets (summary data) ---
            'widgets' => [
                'totalPatients' => 120,
                'paidBills'     => 85,
                'pendingBills'  => 25,
                'overdue'       => 10,
            ],

            // --- Sample reports table data ---
            'reports' => [
                [
                    'id'     => '#RPT001',
                    'name'   => 'Kim Jennie',
                    'type'   => 'Billing',
                    'date'   => '2025-09-05',
                    'status' => 'Paid',
                    'total'  => '$250',
                ],
                [
                    'id'     => '#RPT002',
                    'name'   => 'Park Jimin',
                    'type'   => 'Appointment',
                    'date'   => '2025-09-07',
                    'status' => 'Completed',
                    'total'  => '$80',
                ],
                [
                    'id'     => '#RPT003',
                    'name'   => 'Lisa Manoban',
                    'type'   => 'Billing',
                    'date'   => '2025-09-08',
                    'status' => 'Pending',
                    'total'  => '$150',
                ],
            ],
        ];

        return view('role_dashboard/receptionist/reports', $data);
    }

}