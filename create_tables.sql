-- Create patients table with all required fields
CREATE TABLE IF NOT EXISTS `patients` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `first_name` varchar(100) NOT NULL,
    `middle_name` varchar(100) DEFAULT NULL,
    `last_name` varchar(100) NOT NULL,
    `date_of_birth` date DEFAULT NULL,
    `gender` varchar(10) DEFAULT NULL,
    `phone` varchar(20) DEFAULT NULL,
    `email` varchar(100) DEFAULT NULL,
    `address` text DEFAULT NULL,
    `status` varchar(50) NOT NULL,
    `room` varchar(50) DEFAULT NULL,
    `medical_notes` text DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Pharmacy: prescriptions master
CREATE TABLE IF NOT EXISTS `prescriptions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `patient_id` int(11) NOT NULL,
    `prescriber_id` int(11) DEFAULT NULL,
    `date` date NOT NULL,
    `status` varchar(20) NOT NULL DEFAULT 'active', -- active|partial|fulfilled|expired|void
    `notes` text DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `rx_patient_id` (`patient_id`),
    CONSTRAINT `fk_rx_patient` FOREIGN KEY (`patient_id`) REFERENCES `patients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Pharmacy: prescription items
CREATE TABLE IF NOT EXISTS `prescription_items` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `prescription_id` int(11) NOT NULL,
    `medicine_id` int(11) NOT NULL,
    `dose_text` varchar(255) DEFAULT NULL,
    `frequency_text` varchar(255) DEFAULT NULL,
    `duration_days` int(11) DEFAULT NULL,
    `qty_prescribed` int(11) NOT NULL,
    `refills_allowed` int(11) NOT NULL DEFAULT 0,
    `refills_used` int(11) NOT NULL DEFAULT 0,
    `instructions` text DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `rx_item_rx_id` (`prescription_id`),
    KEY `rx_item_med_id` (`medicine_id`),
    CONSTRAINT `fk_rx_item_rx` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_rx_item_med` FOREIGN KEY (`medicine_id`) REFERENCES `medicines`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Pharmacy: dispensations (dispense events)
CREATE TABLE IF NOT EXISTS `dispensations` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `prescription_item_id` int(11) NOT NULL,
    `quantity_dispensed` int(11) NOT NULL,
    `dispensed_at` datetime DEFAULT NULL,
    `pharmacist_id` int(11) DEFAULT NULL,
    `reference` varchar(100) DEFAULT NULL,
    `notes` text DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `disp_item_id` (`prescription_item_id`),
    CONSTRAINT `fk_disp_item` FOREIGN KEY (`prescription_item_id`) REFERENCES `prescription_items`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create contacts table
CREATE TABLE IF NOT EXISTS `contacts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `patient_id` int(11) NOT NULL,
    `phone` varchar(20) DEFAULT NULL,
    `email` varchar(100) DEFAULT NULL,
    `address` text DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `patient_id` (`patient_id`),
    FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create emergency_contacts table
CREATE TABLE IF NOT EXISTS `emergency_contacts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `patient_id` int(11) NOT NULL,
    `name` varchar(100) NOT NULL,
    `relation` varchar(50) DEFAULT NULL,
    `phone` varchar(20) DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `patient_id` (`patient_id`),
    FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create medical_info table
CREATE TABLE IF NOT EXISTS `medical_info` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `patient_id` int(11) NOT NULL,
    `blood_type` varchar(10) DEFAULT NULL,
    `allergies` text DEFAULT NULL,
    `existing_condition` text DEFAULT NULL,
    `primary_physician` varchar(100) DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `patient_id` (`patient_id`),
    FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create insurance table
CREATE TABLE IF NOT EXISTS `insurance` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `patient_id` int(11) NOT NULL,
    `provider` varchar(100) DEFAULT NULL,
    `policy` varchar(100) DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `patient_id` (`patient_id`),
    FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
