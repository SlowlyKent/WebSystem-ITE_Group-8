<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ScheduleModel;
use CodeIgniter\Controller;

class DoctorDashboardController extends Controller
{
    protected $userModel;
    protected $scheduleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->scheduleModel = new ScheduleModel();
        
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if ($userRole !== 'doctor') {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found');
        }
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if ($userRole !== 'doctor') {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found');
        }
        
        // Get today's schedules
        $todaySchedules = $this->scheduleModel->getTodaySchedules($userId);
        
        // Get upcoming schedules (next 7 days)
        $upcomingSchedules = $this->scheduleModel->getUpcomingSchedules($userId, 5);
        
        // Get schedule statistics
        $scheduleStats = $this->scheduleModel->getScheduleStats($userId);

        $data = [
            'title' => 'Doctor Dashboard',
            'user' => [
                'name' => (isset($user['first_name']) ? $user['first_name'] : '') . ' ' . (isset($user['last_name']) ? $user['last_name'] : ''),
                'role' => isset($user['role']) ? $user['role'] : 'doctor',
                'username' => isset($user['username']) ? $user['username'] : ''
            ],
            'todaySchedules' => $todaySchedules,
            'upcomingSchedules' => $upcomingSchedules,
            'scheduleStats' => $scheduleStats
        ];

        return view('role_dashboard/doctor/doctor', $data);
    }

    public function patients()
    {
        // Load patient model and get all patients
        $patientModel = new \App\Models\PatientModel();
        
        try {
            $patients = $patientModel->findAll();
        } catch (\Exception $e) {
            log_message('error', 'Error fetching patients for doctor: ' . $e->getMessage());
            $patients = [];
        }

        $data = [
            'title' => 'Patient Records',
            'patients' => $patients
        ];

        return view('role_dashboard/doctor/patient_records', $data);
    }

    public function mySchedule()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if ($userRole !== 'doctor') {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            return redirect()->to('/login')->with('error', 'User not found');
        }

        // Get weekly schedules (current week)
        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
        $weeklySchedules = $this->scheduleModel->getSchedulesByDoctor($userId, $startOfWeek, $endOfWeek);
        
        // Get today's schedules
        $todaySchedules = $this->scheduleModel->getSchedulesByDoctor($userId, date('Y-m-d'), date('Y-m-d'));

        $data = [
            'title' => 'My Schedule',
            'currentPage' => 'my-schedule',
            'user' => [
                'name' => (isset($user['first_name']) ? $user['first_name'] : '') . ' ' . (isset($user['last_name']) ? $user['last_name'] : ''),
                'role' => isset($user['role']) ? $user['role'] : 'doctor'
            ],
            'weeklySchedules' => $weeklySchedules,
            'todaySchedules' => $todaySchedules
        ];

        return view('role_dashboard/doctor/myshedule', $data);
    }

    public function viewPatient($id)
    {
        $patientModel = new \App\Models\PatientModel();
        $emergencyContactModel = new \App\Models\EmergencyContactModel();
        $contactModel = new \App\Models\ContactModel();
        $medicalInfoModel = new \App\Models\MedicalInfoModel();
        $insuranceModel = new \App\Models\InsuranceModel();

        $patient = $patientModel->find($id);
        
        if (!$patient) {
            session()->setFlashdata('error', 'Patient not found');
            return redirect()->to('/doctor/patients');
        }

        // Get related information
        $emergencyContact = $emergencyContactModel->where('patient_id', $id)->first();
        $contact = $contactModel->where('patient_id', $id)->first();
        $medicalInfo = $medicalInfoModel->where('patient_id', $id)->first();
        $insurance = $insuranceModel->where('patient_id', $id)->first();

        $data = [
            'title' => 'Patient Details',
            'patient' => $patient,
            'emergency_contact' => $emergencyContact,
            'contact' => $contact,
            'medical_info' => $medicalInfo,
            'insurance' => $insurance
        ];

        return view('role_dashboard/doctor/patient_detail', $data);
    }

    public function profile()
    {
        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            session()->setFlashdata('error', 'User not found');
            return redirect()->to('/doctor/dashboard');
        }

        $data = [
            'title' => 'Doctor Profile',
            'user' => $user
        ];

        return view('role_dashboard/doctor/profile', $data);
    }

    public function updateProfile()
    {
        $userId = session()->get('userId');
        
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
        ];

        // Validate input
        if (!$this->validate([
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->update($userId, $data);
        
        session()->setFlashdata('success', 'Profile updated successfully');
        return redirect()->to('/doctor/profile');
    }

    public function settings()
    {
        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);
        
        $data = [
            'title' => 'Doctor Settings',
            'user' => [
                'name' => (isset($user['first_name']) ? $user['first_name'] : '') . ' ' . (isset($user['last_name']) ? $user['last_name'] : ''),
                'role' => isset($user['role']) ? $user['role'] : 'doctor',
                'username' => isset($user['username']) ? $user['username'] : ''
            ]
        ];

        return view('role_dashboard/doctor/settings', $data);
    }

    public function labRequests()
    {
        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);
        
        $data = [
            'title' => 'Lab Requests & Results',
            'user' => [
                'name' => (isset($user['first_name']) ? $user['first_name'] : '') . ' ' . (isset($user['last_name']) ? $user['last_name'] : ''),
                'role' => isset($user['role']) ? $user['role'] : 'doctor',
                'username' => isset($user['username']) ? $user['username'] : ''
            ]
        ];

        return view('role_dashboard/doctor/labreq', $data);
    }

    public function prescriptions()
    {
        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);
        
        $data = [
            'title' => 'Prescriptions',
            'user' => [
                'name' => (isset($user['first_name']) ? $user['first_name'] : '') . ' ' . (isset($user['last_name']) ? $user['last_name'] : ''),
                'role' => isset($user['role']) ? $user['role'] : 'doctor',
                'username' => isset($user['username']) ? $user['username'] : ''
            ]
        ];

        return view('role_dashboard/doctor/prescription', $data);
    }
}
