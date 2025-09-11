<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'first_name', 'middle_name', 'last_name', 'date_of_birth', 'gender',
        'phone', 'email', 'address', 'status', 'room', 'medical_notes'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'first_name' => 'required|min_length[2]|max_length[100]',
        'last_name' => 'required|min_length[2]|max_length[100]',
        'status' => 'required|in_list[Active,Inactive,Discharged]',
    ];

    protected $validationMessages = [
        'first_name' => [
            'required' => 'First name is required',
            'min_length' => 'First name must be at least 2 characters long',
        ],
        'last_name' => [
            'required' => 'Last name is required',
            'min_length' => 'Last name must be at least 2 characters long',
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Please select a valid status',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Generate unique patient ID
    public function generatePatientId()
    {
        $prefix = 'P';
        $year = date('Y');
        $month = date('m');
        
        // Get the last patient ID for this month
        $lastPatient = $this->where('patient_id LIKE', "{$prefix}{$year}{$month}%")
                            ->orderBy('patient_id', 'DESC')
                            ->first();
        
        if ($lastPatient) {
            $lastNumber = (int) substr($lastPatient['patient_id'], -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Get patient by patient ID
    public function getPatientByPatientId($patientId)
    {
        return $this->where('patient_id', $patientId)->first();
    }

    // Search patients
    public function searchPatients($searchTerm)
    {
        return $this->like('patient_id', $searchTerm)
                    ->orLike('first_name', $searchTerm)
                    ->orLike('last_name', $searchTerm)
                    ->orLike('phone', $searchTerm)
                    ->orLike('email', $searchTerm)
                    ->findAll();
    }

    // Get patients by status
    public function getPatientsByStatus($status)
    {
        return $this->where('status', $status)->findAll();
    }

    // Get patient's full name
    public function getFullName($patientId)
    {
        $patient = $this->find($patientId);
        return $patient ? $patient['first_name'] . ' ' . $patient['last_name'] : '';
    }

    // Get patient statistics
    public function getPatientStats()
    {
        return [
            'total' => $this->countAll(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'deceased' => $this->where('status', 'deceased')->countAllResults(),
        ];
    }
}
