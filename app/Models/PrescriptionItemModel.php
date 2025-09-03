<?php

namespace App\Models;

use CodeIgniter\Model;

class PrescriptionItemModel extends Model
{
    protected $table = 'prescription_items';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'prescription_id', 'medicine_id', 'dose_text', 'frequency_text', 'duration_days', 'qty_prescribed', 'refills_allowed', 'refills_used', 'instructions'
    ];
}
