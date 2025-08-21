<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        
        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validate input
        if (empty($username) || empty($password)) {
            session()->setFlashdata('error', 'Username and password are required');
            return redirect()->back()->withInput();
        }

        // Attempt to authenticate user
        $user = $this->userModel->getUserByCredentials($username, $password);

        if ($user) {
            // Set session data
            session()->set([
                'isLoggedIn' => true,
                'userId' => $user['id'],
                'username' => $user['username'],
                'fullName' => $user['first_name'] . ' ' . $user['last_name'],
                'role' => $user['role'],
                'email' => $user['email']
            ]);

            // Log successful login
            log_message('info', "User {$username} logged in successfully");

            // Redirect based on role
            return redirect()->to('/dashboard');
        } else {
            session()->setFlashdata('error', 'Invalid username or password');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        $username = session()->get('username');
        
        // Clear session
        session()->destroy();
        
        // Log logout
        if ($username) {
            log_message('info', "User {$username} logged out");
        }

        session()->setFlashdata('success', 'You have been logged out successfully');
        return redirect()->to('/login');
    }

    public function changePassword()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if ($this->request->getMethod() === 'post') {
            $currentPassword = $this->request->getPost('current_password');
            $newPassword = $this->request->getPost('new_password');
            $confirmPassword = $this->request->getPost('confirm_password');

            // Validate current password
            $user = $this->userModel->find(session()->get('userId'));
            if (!password_verify($currentPassword, $user['password'])) {
                session()->setFlashdata('error', 'Current password is incorrect');
                return redirect()->back();
            }

            // Validate new password
            if ($newPassword !== $confirmPassword) {
                session()->setFlashdata('error', 'New passwords do not match');
                return redirect()->back();
            }

            if (strlen($newPassword) < 6) {
                session()->setFlashdata('error', 'New password must be at least 6 characters long');
                return redirect()->back();
            }

            // Update password
            $this->userModel->update(session()->get('userId'), [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT)
            ]);

            session()->setFlashdata('success', 'Password changed successfully');
            return redirect()->to('/dashboard');
        }

        return view('auth/change_password');
    }

    public function forgotPassword()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            
            // Check if email exists
            $user = $this->userModel->where('email', $email)->first();
            
            if ($user) {
                // In a real application, you would send a password reset email here
                session()->setFlashdata('success', 'If the email exists, a password reset link has been sent');
            } else {
                // Don't reveal if email exists or not for security
                session()->setFlashdata('success', 'If the email exists, a password reset link has been sent');
            }
            
            return redirect()->to('/login');
        }

        return view('auth/forgot_password');
    }
}
