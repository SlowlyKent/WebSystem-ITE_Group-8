<?php
namespace App\Models;

use CodeIgniter\Model;

class DispensationModel extends Model
{
    protected $table = 'dispensations';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['prescription_id','dispense_date','notes','created_at','updated_at'];
    protected $useTimestamps = true;
}
