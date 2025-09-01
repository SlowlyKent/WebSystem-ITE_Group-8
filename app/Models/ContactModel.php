<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'patient_id', 'phone', 'email', 'address'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'patient_id' => 'required|integer',
        'phone' => 'required|min_length[10]|max_length[20]',
        'email' => 'permit_empty|valid_email|max_length[100]',
        'address' => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [
        'patient_id' => [
            'required' => 'Patient ID is required',
            'integer' => 'Patient ID must be an integer',
        ],
        'phone' => [
            'required' => 'Phone number is required',
            'min_length' => 'Phone number must be at least 10 digits',
        ],
        'email' => [
            'valid_email' => 'Please provide a valid email address',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
