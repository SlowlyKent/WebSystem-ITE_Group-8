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
            ['id' => 1, 'fullName' => 'John Doe', 'contact' => '09123456789', 'dob' => '1990-05-10'],
            ['id' => 2, 'fullName' => 'Jane Smith', 'contact' => '09876543210', 'dob' => '1985-08-22'],
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
            ['name' => 'Dr. Alice', 'specialization' => 'Cardiology', 'days' => 'Mon, Wed, Fri'],
            ['name' => 'Dr. Bob', 'specialization' => 'Pediatrics', 'days' => 'Tue, Thu'],
        ];

        $nurseSchedule = [
            ['name' => 'Nurse Clara', 'shift' => 'Morning', 'days' => 'Mon-Fri'],
            ['name' => 'Nurse David', 'shift' => 'Night', 'days' => 'Mon-Sat'],
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
            ]
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
            // Placeholder for generated reports
            'reportData' => []
        ];

        return view('role_dashboard/receptionist/reports', $data);
    }
}