<?php

namespace App\Models;

use CodeIgniter\Model;

class InsuranceModel extends Model
{
    protected $table = 'insurance';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'patient_id', 'provider', 'policy'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'patient_id' => 'required|integer',
        'provider' => 'permit_empty|max_length[100]',
        'policy' => 'permit_empty|max_length[100]',
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
