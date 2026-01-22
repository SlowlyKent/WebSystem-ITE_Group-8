<?php
namespace App\Models;

use CodeIgniter\Model;

class NurseModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['first_name', 'last_name', 'role', 'email', 'password'];

    public function getAllNurses()
    {
        return $this->where('role', 'nurse')->findAll();
    }
}