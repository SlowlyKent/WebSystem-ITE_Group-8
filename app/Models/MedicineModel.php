<?php
namespace App\Models;

use CodeIgniter\Model;

class MedicineModel extends Model
{
    protected $table = 'medicines';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['name','form','strength','reorder_level','created_at','updated_at'];
    protected $useTimestamps = true;
}
