<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SetupController extends BaseController
{
    public function createSchedulesTable()
    {
        $db = \Config\Database::connect();
        
        try {
            // Drop existing table if it exists
            $db->query("DROP TABLE IF EXISTS `schedules`");
            
            // Create schedules table
            $sql = "CREATE TABLE `schedules` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `doctor_id` int(11) UNSIGNED NOT NULL,
                `title` varchar(255) NOT NULL,
                `description` text DEFAULT NULL,
                `schedule_date` date NOT NULL,
                `start_time` time NOT NULL,
                `end_time` time NOT NULL,
                `schedule_type` enum('consultation','surgery','rounds','emergency','meeting','other') NOT NULL DEFAULT 'consultation',
                `location` varchar(255) DEFAULT NULL,
                `patient_id` int(11) DEFAULT NULL,
                `status` enum('scheduled','in_progress','completed','cancelled','rescheduled') NOT NULL DEFAULT 'scheduled',
                `notes` text DEFAULT NULL,
                `created_by` int(11) UNSIGNED NOT NULL,
                `created_at` datetime NOT NULL,
                `updated_at` datetime NOT NULL,
                PRIMARY KEY (`id`),
                KEY `idx_doctor_date` (`doctor_id`, `schedule_date`),
                KEY `idx_schedule_date` (`schedule_date`),
                KEY `idx_status` (`status`),
                CONSTRAINT `fk_schedules_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
                CONSTRAINT `fk_schedules_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            
            $db->query($sql);
            
            // Clear existing schedules and insert new ones for doctor ID 1
            $db->query("DELETE FROM schedules");
        
            $today = date('Y-m-d');
            $tomorrow = date('Y-m-d', strtotime('+1 day'));
            $dayAfter = date('Y-m-d', strtotime('+2 days'));
        
            // Insert sample schedule data for doctor ID 1 (Dr. Smith)
            $sampleSchedules = [
                [
                    'doctor_id' => 1,
                    'title' => 'Morning Consultation',
                    'description' => 'Regular patient consultation',
                    'schedule_date' => $today,
                    'start_time' => '09:00:00',
                    'end_time' => '10:00:00',
                    'schedule_type' => 'consultation',
                    'location' => 'Room 101',
                    'patient_id' => null,
                    'status' => 'scheduled',
                    'notes' => 'Regular checkup appointment',
                    'created_by' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'doctor_id' => 1,
                    'title' => 'Patient Follow-up',
                    'description' => 'Follow-up consultation',
                    'schedule_date' => $today,
                    'start_time' => '11:00:00',
                    'end_time' => '11:30:00',
                    'schedule_type' => 'consultation',
                    'location' => 'Room 102',
                    'patient_id' => null,
                    'status' => 'scheduled',
                    'notes' => 'Follow-up visit',
                    'created_by' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'doctor_id' => 1,
                    'title' => 'Surgery - Minor Procedure',
                    'description' => 'Minor surgical procedure',
                    'schedule_date' => $today,
                    'start_time' => '14:00:00',
                    'end_time' => '15:30:00',
                    'schedule_type' => 'surgery',
                    'location' => 'Operating Room 1',
                    'patient_id' => null,
                    'status' => 'scheduled',
                    'notes' => 'Minor outpatient procedure',
                    'created_by' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'doctor_id' => 1,
                    'title' => 'Patient Rounds',
                    'description' => 'Daily patient rounds',
                    'schedule_date' => $tomorrow,
                    'start_time' => '08:00:00',
                    'end_time' => '10:00:00',
                    'schedule_type' => 'rounds',
                    'location' => 'Ward A',
                    'patient_id' => null,
                    'status' => 'scheduled',
                    'notes' => 'Check on all assigned patients',
                    'created_by' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'doctor_id' => 1,
                    'title' => 'Emergency Consultation',
                    'description' => 'Emergency patient consultation',
                    'schedule_date' => $tomorrow,
                    'start_time' => '15:00:00',
                    'end_time' => '16:00:00',
                    'schedule_type' => 'emergency',
                    'location' => 'Emergency Room',
                    'patient_id' => null,
                    'status' => 'scheduled',
                    'notes' => 'Emergency case',
                    'created_by' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ];         
            
            $builder = $db->table('schedules');
            foreach ($sampleSchedules as $schedule) {
                $builder->insert($schedule);
            }
            
            echo "Schedules table created successfully with sample data!";
            
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
