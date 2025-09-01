<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PatientModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    protected $userModel;
    protected $patientModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->patientModel = new PatientModel();
    }

    public function index()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Dashboard',
            'user' => [
                'fullName' => session()->get('fullName'),
                'role' => session()->get('role'),
                'username' => session()->get('username')
            ]
        ];

        // Get dashboard statistics based on user role
        $data['stats'] = $this->getDashboardStats();
        
        // Get recent activities
        $data['recentActivities'] = $this->getRecentActivities();

        return view('dashboard/index', $data);
    }

    private function getDashboardStats()
    {
        $stats = [
            'totalPatients' => 0,
            'totalDoctors' => 0,
            'totalNurses' => 0,
            'totalAppointments' => 0,
            'pendingLabs' => 0,
            'revenue' => 0
        ];

        // Get counts based on user role
        $userRole = session()->get('role');
        
        if (in_array($userRole, ['admin', 'it_staff'])) {
            // Admin and IT staff can see all statistics
            $stats['totalPatients'] = $this->patientModel->countAll();
            $stats['totalDoctors'] = $this->userModel->where('role', 'doctor')->countAllResults();
            $stats['totalNurses'] = $this->userModel->where('role', 'nurse')->countAllResults();
            $stats['totalAppointments'] = 0; // Will be implemented when appointments table is created
            $stats['pendingLabs'] = 0; // Will be implemented when lab table is created
            $stats['revenue'] = 0; // Will be implemented when billing table is created
        } elseif ($userRole === 'doctor') {
            // Doctors can see limited statistics
            $stats['totalPatients'] = $this->patientModel->countAll();
            $stats['totalAppointments'] = 0; // Will show only doctor's appointments
        } elseif ($userRole === 'nurse') {
            // Nurses can see limited statistics
            $stats['totalPatients'] = $this->patientModel->countAll();
        }

        return $stats;
    }

    private function getRecentActivities()
    {
        // This will be implemented when activity logging is added
        return [
            [
                'type' => 'patient_registration',
                'description' => 'New patient registered',
                'timestamp' => date('Y-m-d H:i:s'),
                'user' => 'System'
            ],
            [
                'type' => 'user_login',
                'description' => 'User logged in',
                'timestamp' => date('Y-m-d H:i:s'),
                'user' => session()->get('username')
            ]
        ];
    }

    public function profile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'Profile',
            'user' => $user
        ];

        return view('dashboard/profile', $data);
    }

    public function updateProfile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('userId');
        
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email')
        ];

        // Set custom validation rules for profile update (only validate fields being updated)
        $this->userModel->setValidationRules([
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']'
        ]);

        if ($this->userModel->update($userId, $data)) {
            // Update session data
            session()->set('fullName', $data['first_name'] . ' ' . $data['last_name']);
            session()->set('email', $data['email']);
            
            session()->setFlashdata('success', 'Profile updated successfully');
        } else {
            // Get validation errors for debugging
            $errors = $this->userModel->errors();
            
            if (!empty($errors)) {
                $errorMessage = 'Validation errors: ' . implode(', ', $errors);
                session()->setFlashdata('error', $errorMessage);
            } else {
                session()->setFlashdata('error', 'Failed to update profile');
            }
        }

        return redirect()->to('/dashboard/profile');
    }

    public function changePassword()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('userId');
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validate passwords match
        if ($newPassword !== $confirmPassword) {
            session()->setFlashdata('error', 'New passwords do not match');
            return redirect()->to('/dashboard/profile');
        }

        // Get current user data
        $user = $this->userModel->find($userId);
        
        // Verify current password
        if (!password_verify($currentPassword, $user['password'])) {
            session()->setFlashdata('error', 'Current password is incorrect');
            return redirect()->to('/dashboard/profile');
        }

        // Update password
        $data = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ];

        if ($this->userModel->update($userId, $data)) {
            session()->setFlashdata('success', 'Password changed successfully');
        } else {
            session()->setFlashdata('error', 'Failed to change password');
        }

        return redirect()->to('/dashboard/profile');
    }
}
