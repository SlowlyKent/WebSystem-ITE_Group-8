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
        'patient_id', 'first_name', 'last_name', 'date_of_birth', 'gender',
        'phone', 'email', 'address', 'blood_type', 'emergency_contact',
        'emergency_phone', 'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'patient_id' => 'required|is_unique[patients.patient_id,id,{id}]',
        'first_name' => 'required|min_length[2]|max_length[100]',
        'last_name' => 'required|min_length[2]|max_length[100]',
        'date_of_birth' => 'required|valid_date',
        'gender' => 'required|in_list[male,female,other]',
        'phone' => 'required|min_length[10]|max_length[20]',
        'email' => 'permit_empty|valid_email',
        'blood_type' => 'permit_empty|in_list[A+,A-,B+,B-,AB+,AB-,O+,O-]',
        'status' => 'required|in_list[active,inactive,deceased]',
    ];

    protected $validationMessages = [
        'patient_id' => [
            'required' => 'Patient ID is required',
            'is_unique' => 'Patient ID already exists',
        ],
        'first_name' => [
            'required' => 'First name is required',
            'min_length' => 'First name must be at least 2 characters long',
        ],
        'last_name' => [
            'required' => 'Last name is required',
            'min_length' => 'Last name must be at least 2 characters long',
        ],
        'date_of_birth' => [
            'required' => 'Date of birth is required',
            'valid_date' => 'Please enter a valid date',
        ],
        'gender' => [
            'required' => 'Gender is required',
            'in_list' => 'Please select a valid gender',
        ],
        'phone' => [
            'required' => 'Phone number is required',
            'min_length' => 'Phone number must be at least 10 digits',
        ],
        'email' => [
            'valid_email' => 'Please enter a valid email address',
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
