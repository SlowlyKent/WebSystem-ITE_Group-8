<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin',
            'email' => 'admin@hms.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'role' => 'admin',
            'status' => 'active',
            'created_by' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Check if admin already exists
        $existingAdmin = $this->db->table('users')->where('username', 'admin')->get()->getRow();
        
        if (!$existingAdmin) {
            $this->db->table('users')->insert($data);
            echo "✅ Admin user created successfully!\n";
            echo "Username: admin\n";
            echo "Password: admin123\n";
        } else {
            echo "ℹ️ Admin user already exists!\n";
        }
    }
}
