<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointmentsTable extends Migration
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
            'patient_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'doctor_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'appointment_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'appointment_time' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'duration_minutes' => [
                'type' => 'INT',
                'default' => 30,
                'null' => false,
            ],
            'appointment_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Scheduled', 'Confirmed', 'In Progress', 'Completed', 'Cancelled', 'No Show'],
                'default' => 'Scheduled',
                'null' => false,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
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
        //primary key
        $this->forge->addKey('id', true);

        //indexes
        $this->forge->addKey('appointment_date');
        $this->forge->addKey('status');

        //If a patient/user is deleted, the appointment row itself is deleted automatically.
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('doctor_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        
        //create table
        $this->forge->createTable('appointments');

        //Ensures a doctor can’t have two appointments at the exact same date/time.
        $this->db->query('ALTER TABLE appointments ADD UNIQUE KEY unique_doctor_schedule (doctor_id, appointment_date, appointment_time)');
    }   

    public function down()
    {
        $this->forge->dropTable('appointments');
    }
}

