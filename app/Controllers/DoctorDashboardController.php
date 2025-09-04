<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class DoctorDashboardController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            redirect()->to('/login')->send();
            exit;
        }
        
        // Check if user has doctor role
        if (session()->get('role') !== 'doctor') {
            redirect()->to('/dashboard')->send();
            exit;
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Doctor Dashboard',
            'user' => [
                'name' => session()->get('fullName'),
                'role' => session()->get('role'),
                'username' => session()->get('username')
            ]
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
        
        // Update session data
        session()->set('fullName', $data['first_name'] . ' ' . $data['last_name']);
        session()->set('email', $data['email']);
        
        session()->setFlashdata('success', 'Profile updated successfully');
        return redirect()->to('/doctor/profile');
    }

    public function settings()
    {
        $data = [
            'title' => 'Doctor Settings',
            'user' => [
                'name' => session()->get('fullName'),
                'role' => session()->get('role'),
                'username' => session()->get('username')
            ]
        ];

        return view('role_dashboard/doctor/settings', $data);
    }
}
