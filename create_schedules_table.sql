-- Create schedules table
DROP TABLE IF EXISTS `schedules`;

CREATE TABLE `schedules` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample schedules for testing
INSERT INTO `schedules` (`doctor_id`, `title`, `description`, `schedule_date`, `start_time`, `end_time`, `schedule_type`, `location`, `patient_id`, `status`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Morning Consultation', 'Regular patient consultation', '2025-09-12', '09:00:00', '10:00:00', 'consultation', 'Room 101', NULL, 'scheduled', 'Regular checkup appointment', 1, NOW(), NOW()),
(1, 'Surgery - Appendectomy', 'Emergency appendectomy procedure', '2025-09-12', '14:00:00', '16:00:00', 'surgery', 'Operating Room 2', NULL, 'scheduled', 'Patient requires immediate surgery', 1, NOW(), NOW()),
(1, 'Patient Rounds', 'Daily patient rounds', '2025-09-13', '08:00:00', '10:00:00', 'rounds', 'Ward A', NULL, 'scheduled', 'Check on all assigned patients', 1, NOW(), NOW());
