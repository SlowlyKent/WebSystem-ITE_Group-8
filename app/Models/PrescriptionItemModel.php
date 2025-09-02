<?php
namespace App\Models;

use CodeIgniter\Model;

class PrescriptionItemModel extends Model
{
    protected $table = 'prescription_items';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['prescription_id','medicine_id','dosage','qty','dispensed_qty','created_at','updated_at'];
    protected $useTimestamps = true;
}
