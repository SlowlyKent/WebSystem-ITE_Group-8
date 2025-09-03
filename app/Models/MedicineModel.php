<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicineModel extends Model
{
    protected $table = 'medicines';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'name', 'generic_name', 'category', 'sku', 'batch_no', 'quantity', 'reorder_level', 'expiry_date', 'unit', 'price'
    ];

    // Auto-generate SKU on insert when missing
    protected $beforeInsert = ['ensureSku'];

    protected function ensureSku(array $data)
    {
        if (!isset($data['data'])) {
            return $data;
        }

        $sku = trim((string)($data['data']['sku'] ?? ''));
        if ($sku !== '') {
            return $data; // user provided
        }

        // Build a base from name/category: e.g., AMOX-AB-<random>
        $name = strtoupper(preg_replace('/[^A-Za-z0-9]+/', '', (string)($data['data']['name'] ?? 'MED')));
        $cat  = strtoupper(preg_replace('/[^A-Za-z0-9]+/', '', (string)($data['data']['category'] ?? '')));
        $namePart = substr($name, 0, 4);
        $catPart  = $cat ? '-'.substr($cat, 0, 2) : '';

        // Ensure uniqueness by trying a few random suffixes
        $attempts = 0;
        do {
            $rand = substr(strtoupper(bin2hex(random_bytes(2))), 0, 4); // 4 hex chars
            $candidate = sprintf('%s%s-%s', $namePart ?: 'MED', $catPart, $rand);
            $exists = $this->where('sku', $candidate)->countAllResults() > 0;
            $attempts++;
        } while ($exists && $attempts < 10);

        $data['data']['sku'] = $candidate;
        return $data;
    }
}
