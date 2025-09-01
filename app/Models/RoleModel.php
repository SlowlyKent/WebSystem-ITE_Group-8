<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name', 'display_name', 'description', 'level', 'is_active'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[50]|',
        'display_name' => 'required|min_length[3]|max_length[100]',
        'level' => 'required|integer',
        'is_active' => 'required|in_list[0,1]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Role name is required',
            'is_unique' => 'Role name already exists',
        ],
        'display_name' => [
            'required' => 'Display name is required',
        ],
    ];

    // Get all active roles
    public function getActiveRoles()
    {
        return $this->where('is_active', 1)->orderBy('level', 'ASC')->findAll();
    }

    // Get role by name
    public function getRoleByName($name)
    {
        return $this->where('name', $name)->first();
    }

    // Get roles by level
    public function getRolesByLevel($maxLevel)
    {
        return $this->where('is_active', 1)
                   ->where('level <=', $maxLevel)
                   ->orderBy('level', 'ASC')
                   ->findAll();
    }

    // Check if role exists
    public function roleExists($name)
    {
        return $this->where('name', $name)->countAllResults() > 0;
    }
}
