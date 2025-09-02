<?php
namespace App\Models;

use CodeIgniter\Model;

class MedicineBatchModel extends Model
{
    protected $table = 'medicine_batches';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['medicine_id','batch_no','expiry_date','stock_qty','created_at','updated_at'];
    protected $useTimestamps = true;
}
