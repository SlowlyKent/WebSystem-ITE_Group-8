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

    private function isAllowed()
    {
        $role = session()->get('role');
        return in_array($role, ['admin', 'it_staff']);
    }

    public function index()
    {
        if (!$this->isAllowed()) return redirect()->to('/dashboard');
        $users = $this->userModel->findAll();
        return view('role_dashboard/admin/UserManagement/index', ['users' => $users]);
    }

    public function add()
    {
        if (!$this->isAllowed()) return redirect()->to('/dashboard');
        return view('role_dashboard/admin/UserManagement/add_user');
    }

    public function create()
    {
        if (!$this->isAllowed()) return redirect()->to('/dashboard');
        $role = session()->get('role');

        $data = [
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => $this->request->getPost('password'),
            'role'       => $this->request->getPost('role'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'status'     => 'active',
            'created_by' => session()->get('id'),
        ];

        // IT Staff cannot create Admin
        if ($role === 'it_staff' && $data['role'] === 'admin') {
            return redirect()->back()->with('error', 'IT Staff cannot create Admin accounts.');
        }

        // Validate input
        if (!$this->validate([
            'username'   => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email'      => 'required|valid_email|is_unique[users.email]',
            'password'   => 'required|min_length[6]',
            'role'       => 'required|in_list[admin,it_staff,doctor,nurse,pharmacist,receptionist]',
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name'  => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Hash password before insert
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->userModel->insert($data);
        return redirect()->to('/user-management')->with('success', 'User created!');
    }
}