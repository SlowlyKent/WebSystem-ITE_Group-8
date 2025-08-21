<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserManagementController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Check if user is logged in and has permission
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin', 'it_staff'])) {
            session()->setFlashdata('error', 'Access denied. Insufficient permissions.');
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'User Management',
            'users' => $this->userModel->getActiveUsers(),
            'userRole' => $userRole
        ];

        return view('user_management/index', $data);
    }

    public function create()
    {
        // Check permissions
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin', 'it_staff'])) {
            session()->setFlashdata('error', 'Access denied. Insufficient permissions.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            $userData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'role' => $this->request->getPost('role'),
                'status' => 'active',
                'created_by' => session()->get('userId')
            ];

            // Validate role assignment permissions
            if (!$this->canAssignRole($userRole, $userData['role'])) {
                session()->setFlashdata('error', 'You cannot assign this role. Insufficient permissions.');
                return redirect()->back()->withInput();
            }

            if ($this->userModel->insert($userData)) {
                session()->setFlashdata('success', 'User created successfully');
                return redirect()->to('/user-management');
            } else {
                session()->setFlashdata('error', 'Failed to create user');
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Create User',
            'roles' => $this->getAssignableRoles($userRole)
        ];

        return view('user_management/create', $data);
    }

    public function edit($id = null)
    {
        // Check permissions
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin', 'it_staff'])) {
            session()->setFlashdata('error', 'Access denied. Insufficient permissions.');
            return redirect()->to('/dashboard');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            session()->setFlashdata('error', 'User not found');
            return redirect()->to('/user-management');
        }

        if ($this->request->getMethod() === 'post') {
            $updateData = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'status' => $this->request->getPost('status')
            ];

            // Only allow role change if user has permission
            if ($this->canAssignRole($userRole, $this->request->getPost('role'))) {
                $updateData['role'] = $this->request->getPost('role');
            }

            // Update password if provided
            $newPassword = $this->request->getPost('new_password');
            if (!empty($newPassword)) {
                $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            }

            if ($this->userModel->update($id, $updateData)) {
                session()->setFlashdata('success', 'User updated successfully');
                return redirect()->to('/user-management');
            } else {
                session()->setFlashdata('error', 'Failed to update user');
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $this->getAssignableRoles($userRole)
        ];

        return view('user_management/edit', $data);
    }

    public function delete($id = null)
    {
        // Check permissions
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin', 'it_staff'])) {
            session()->setFlashdata('error', 'Access denied. Insufficient permissions.');
            return redirect()->to('/dashboard');
        }

        // Prevent self-deletion
        if ($id == session()->get('userId')) {
            session()->setFlashdata('error', 'You cannot delete your own account');
            return redirect()->to('/user-management');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            session()->setFlashdata('error', 'User not found');
            return redirect()->to('/user-management');
        }

        // Soft delete by setting status to inactive
        if ($this->userModel->update($id, ['status' => 'inactive'])) {
            session()->setFlashdata('success', 'User deactivated successfully');
        } else {
            session()->setFlashdata('error', 'Failed to deactivate user');
        }

        return redirect()->to('/user-management');
    }

    private function canAssignRole($currentUserRole, $targetRole)
    {
        $roleHierarchy = [
            'admin' => ['admin', 'it_staff', 'doctor', 'nurse', 'pharmacist', 'receptionist'],
            'it_staff' => ['doctor', 'nurse', 'pharmacist', 'receptionist'],
        ];

        return in_array($targetRole, $roleHierarchy[$currentUserRole] ?? []);
    }

    private function getAssignableRoles($currentUserRole)
    {
        $roleHierarchy = [
            'admin' => ['admin', 'it_staff', 'doctor', 'nurse', 'pharmacist', 'receptionist'],
            'it_staff' => ['doctor', 'nurse', 'pharmacist', 'receptionist'],
        ];

        return $roleHierarchy[$currentUserRole] ?? [];
    }
}
