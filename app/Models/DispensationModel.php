<?php

namespace App\Models;

use CodeIgniter\Model;

class DispensationModel extends Model
{
    protected $table = 'dispensations';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'prescription_item_id', 'quantity_dispensed', 'dispensed_at', 'pharmacist_id', 'reference', 'notes'
    ];
}
