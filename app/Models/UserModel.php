<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'username', 'email', 'password', 'first_name', 'last_name',
        'role', 'status', 'created_by'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'first_name' => 'required|min_length[2]|max_length[100]',
        'last_name' => 'required|min_length[2]|max_length[100]',
        'role' => 'required|in_list[admin,it_staff,doctor,nurse,pharmacist,receptionist]',
        'status' => 'required|in_list[active,inactive,suspended]',
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'min_length' => 'Username must be at least 3 characters long',
            'is_unique' => 'Username already exists',
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique' => 'Email already exists',
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters long',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Get user by credentials
    public function getUserByCredentials($username, $password)
    {
        $user = $this->where('username', $username)
                     ->where('status', 'active')
                     ->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // Get users by role
    public function getUsersByRole($role)
    {
        return $this->where('role', $role)
                    ->where('status', 'active')
                    ->findAll();
    }

    // Get all active users
    public function getActiveUsers()
    {
        return $this->where('status', 'active')->findAll();
    }

    // Check if user has permission
    public function hasPermission($userId, $requiredRole)
    {
        $user = $this->find($userId);
        if (!$user) return false;

        $roleHierarchy = [
            'admin' => ['admin', 'it_staff', 'doctor', 'nurse', 'pharmacist', 'receptionist'],
            'it_staff' => ['doctor', 'nurse', 'pharmacist', 'receptionist'],
            'doctor' => ['nurse'],
            'nurse' => [],
            'pharmacist' => [],
            'receptionist' => [],
        ];

        return in_array($requiredRole, $roleHierarchy[$user['role']] ?? []);
    }

    // Get user's full name
    public function getFullName($userId)
    {
        $user = $this->find($userId);
        return $user ? $user['first_name'] . ' ' . $user['last_name'] : '';
    }
}
