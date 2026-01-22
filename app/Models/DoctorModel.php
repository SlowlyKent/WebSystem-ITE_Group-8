<?php
namespace App\Models;

use CodeIgniter\Model;

class DoctorModel extends Model
{
    protected $table = 'users'; // assuming doctors are in 'users' table
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['first_name', 'last_name', 'role'];
    
    // Only get users who are doctors
    public function getAllDoctors()
    {
        return $this->where('role', 'doctor')->findAll();
    }
}
