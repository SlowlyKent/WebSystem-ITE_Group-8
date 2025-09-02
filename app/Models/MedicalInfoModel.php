<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicalInfoModel extends Model
{
    protected $table = 'medical_info';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'patient_id', 'blood_type', 'allergies', 'existing_condition', 'primary_physician'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'patient_id' => 'required|integer',
        'blood_type' => 'permit_empty|max_length[10]',
        'allergies' => 'permit_empty|max_length[255]',
        'existing_condition' => 'permit_empty|max_length[255]',
        'primary_physician' => 'permit_empty|max_length[100]',
    ];

    protected $validationMessages = [
        'patient_id' => [
            'required' => 'Patient ID is required',
            'integer' => 'Patient ID must be an integer',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
