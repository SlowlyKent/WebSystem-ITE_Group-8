<?php
namespace App\Models;

use CodeIgniter\Model;

class PrescriptionModel extends Model
{
    protected $table = 'prescriptions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['patient_id','rx_no','rx_date','status','created_at','updated_at'];
    protected $useTimestamps = true;
}
