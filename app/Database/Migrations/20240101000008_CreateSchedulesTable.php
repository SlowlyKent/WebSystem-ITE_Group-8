<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'doctor_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'schedule_date' => [
                'type' => 'DATE',
            ],
            'start_time' => [
                'type' => 'TIME',
            ],
            'end_time' => [
                'type' => 'TIME',
            ],
            'schedule_type' => [
                'type' => 'ENUM',
                'constraint' => ['consultation', 'surgery', 'rounds', 'emergency', 'meeting', 'other'],
                'default' => 'consultation',
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'patient_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['scheduled', 'in_progress', 'completed', 'cancelled', 'rescheduled'],
                'default' => 'scheduled',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        // Add primary key
        $this->forge->addKey('id', true);
        
        // Create table
        $this->forge->createTable('schedules');
        
        // Add indexes first
        $this->db->query('ALTER TABLE schedules ADD INDEX idx_doctor_date (doctor_id, schedule_date)');
        $this->db->query('ALTER TABLE schedules ADD INDEX idx_schedule_date (schedule_date)');
        $this->db->query('ALTER TABLE schedules ADD INDEX idx_status (status)');
        
        // Add foreign key constraints (only for users table since patients table structure may vary)
        $this->db->query('ALTER TABLE schedules ADD CONSTRAINT fk_schedules_doctor FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE');
        $this->db->query('ALTER TABLE schedules ADD CONSTRAINT fk_schedules_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('schedules');
    }
}
