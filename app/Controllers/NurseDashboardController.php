<?php

namespace App\Controllers;

use App\Models\UserModel;

class NurseDashboardController extends BaseController
{
    public function index()
    {
        // Check if user is logged in and is a nurse
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'nurse') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Nurse Dashboard',
            'user' => [
                'name' => session()->get('fullName'),
                'username' => session()->get('username'),
                'email' => session()->get('email')
            ]
        ];

        return view('role_dashboard/nurse/nurse', $data);
    }

    public function patientAssignments()
    {
        // Check if user is logged in and is a nurse
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'nurse') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Patient Assignments'
        ];

        return view('role_dashboard/nurse/patient_assignments', $data);
    }

    public function vitalSigns()
    {
        // Check if user is logged in and is a nurse
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'nurse') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Vital Signs Recording'
        ];

        return view('role_dashboard/nurse/vital_signs', $data);
    }

    public function medicationAdmin()
    {
        // Check if user is logged in and is a nurse
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'nurse') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Medication Administration'
        ];

        return view('role_dashboard/nurse/medication_admin', $data);
    }

    public function nursingNotes()
    {
        // Check if user is logged in and is a nurse
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'nurse') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Nursing Notes'
        ];

        return view('role_dashboard/nurse/nursing_notes', $data);
    }

    public function shiftHandover()
    {
        // Check if user is logged in and is a nurse
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'nurse') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Shift Handover'
        ];

        return view('role_dashboard/nurse/shift_handover', $data);
    }

    public function profile()
    {
        // Check if user is logged in and is a nurse
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'nurse') {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'My Profile'
        ];

        return view('role_dashboard/nurse/profile', $data);
    }

    public function updateProfile()
    {
        // Check if user is logged in and is a nurse
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'nurse') {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $userId = session()->get('user_id');

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone')
        ];

        if ($userModel->update($userId, $data)) {
            session()->setFlashdata('success', 'Profile updated successfully');
        } else {
            session()->setFlashdata('error', 'Failed to update profile');
        }

        return redirect()->to('/nurse/profile');
    }
}
