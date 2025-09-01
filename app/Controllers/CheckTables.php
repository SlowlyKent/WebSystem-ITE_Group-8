<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CheckTables extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Get list of tables
        $tables = $db->listTables();
        
        echo "Existing tables in database:\n";
        print_r($tables);
        
        // Check structure of patients table if it exists
        if (in_array('patients', $tables)) {
            echo "\nPatients table structure:\n";
            $fields = $db->getFieldData('patients');
            foreach ($fields as $field) {
                echo "{$field->name} ({$field->type})\n";
            }
        }
    }
}
