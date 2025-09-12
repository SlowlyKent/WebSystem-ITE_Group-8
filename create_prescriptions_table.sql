-- Create prescriptions table
CREATE TABLE IF NOT EXISTS `prescriptions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `patient_id` int(11) NOT NULL,
    `doctor_id` int(11) NOT NULL,
    `patient_name` varchar(200) NOT NULL,
    `medication_name` varchar(200) NOT NULL,
    `dosage` varchar(100) NOT NULL,
    `frequency` varchar(100) DEFAULT NULL,
    `duration` varchar(100) DEFAULT NULL,
    `priority` enum('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    `status` enum('active', 'completed', 'cancelled') DEFAULT 'active',
    `notes` text DEFAULT NULL,
    `prescribed_date` datetime DEFAULT CURRENT_TIMESTAMP,
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `patient_id` (`patient_id`),
    KEY `doctor_id` (`doctor_id`),
    FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample prescription data
INSERT INTO `prescriptions` (`patient_id`, `doctor_id`, `patient_name`, `medication_name`, `dosage`, `frequency`, `duration`, `priority`, `status`, `notes`, `prescribed_date`) VALUES
(1, 1, 'John Doe', 'Amoxicillin', '500mg', '3 times daily', '7 days', 'medium', 'active', 'Take with food to avoid stomach upset', '2024-01-20 10:30:00'),
(2, 1, 'Jane Smith', 'Lisinopril', '10mg', 'Once daily', '30 days', 'high', 'active', 'Monitor blood pressure regularly', '2024-01-19 14:15:00'),
(3, 1, 'Mike Johnson', 'Ibuprofen', '400mg', 'As needed', '14 days', 'low', 'completed', 'For pain relief, maximum 3 times per day', '2024-01-18 09:45:00');
