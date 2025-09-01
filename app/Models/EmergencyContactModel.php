<?php

namespace App\Models;

use CodeIgniter\Model;

class EmergencyContactModel extends Model
{
    protected $table = 'emergency_contacts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'patient_id', 'name', 'relation', 'phone'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'patient_id' => 'required|integer',
        'name' => 'required|min_length[2]|max_length[100]',
        'relation' => 'required|min_length[2]|max_length[100]',
        'phone' => 'required|min_length[10]|max_length[20]',
    ];

    protected $validationMessages = [
        'patient_id' => [
            'required' => 'Patient ID is required',
            'integer' => 'Patient ID must be an integer',
        ],
        'name' => [
            'required' => 'Emergency contact name is required',
            'min_length' => 'Name must be at least 2 characters long',
        ],
        'relation' => [
            'required' => 'Relation is required',
            'min_length' => 'Relation must be at least 2 characters long',
        ],
        'phone' => [
            'required' => 'Phone number is required',
            'min_length' => 'Phone number must be at least 10 digits',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
