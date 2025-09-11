<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - HMS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #b9d3c9;
            overflow-x: hidden;
            min-height: 100vh;
            width: 100%;
        }

        .dashboard {
            display: flex;
            width: 100%;
            min-height: 100vh; 
            background: #b9d3c9;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 270px;
            background-color: #052719;
            color: white;
            padding: 15px;
            border-radius: 15px;
            margin: 15px;
            height: calc(100vh - 30px);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
        }

        /* Main Content */
        .main-content {
            margin-left: 300px;
            padding: 20px;
            min-height: 100vh;
            width: calc(100% - 340px);
        }

        .page-header {
            background-color: #052719;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            font-size: 24px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .patient-detail-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-card {
            background-color: #052719;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .info-card h3 {
            color: white;
            margin-bottom: 15px;
            font-size: 18px;
            border-bottom: 2px solid #b9d3c9;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            color: #b9d3c9;
            width: 120px;
            flex-shrink: 0;
        }

        .info-value {
            color: white;
            flex: 1;
        }

        .patient-header {
            background-color: #052719;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .patient-avatar-large {
            width: 80px;
            height: 80px;
            background-color: #052719;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .patient-basic-info h2 {
            color: white;
            margin-bottom: 5px;
        }

        .patient-basic-info p {
            color: #b9d3c9;
            margin-bottom: 3px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            margin-top: 5px;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-discharged {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-admitted {
            background-color: #fff3cd;
            color: #856404;
        }

        .full-width-card {
            grid-column: 1 / -1;
        }

        .notes-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-top: 10px;
        }

        .notes-section h4 {
            color: #1b5e20;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <?= $this->include('role_dashboard/doctor/_doctor_sidebar') ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-user-injured"></i> Patient Details</h1>
            <a href="<?= base_url('doctor/patients') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Patient Records
            </a>
        </div>

        <!-- Patient Header -->
        <div class="patient-header">
            <div class="patient-avatar-large">
                <?= strtoupper(substr($patient['first_name'], 0, 1) . substr($patient['last_name'], 0, 1)) ?>
            </div>
            <div class="patient-basic-info">
                <h2><?= esc($patient['first_name'] . ' ' . ($patient['middle_name'] ? $patient['middle_name'] . ' ' : '') . $patient['last_name']) ?></h2>
                <p><strong>Patient ID:</strong> <?= esc($patient['id']) ?></p>
                <p><strong>Date of Birth:</strong> <?= esc($patient['date_of_birth'] ?? 'N/A') ?></p>
                <p><strong>Gender:</strong> <?= esc($patient['gender'] ?? 'N/A') ?></p>
                <span class="status-badge status-<?= strtolower($patient['status'] ?? 'active') ?>">
                    <?= esc($patient['status'] ?? 'Active') ?>
                </span>
            </div>
        </div>

        <!-- Patient Details Grid -->
        <div class="patient-detail-container">
            <!-- Contact Information -->
            <div class="info-card">
                <h3><i class="fas fa-address-book"></i> Contact Information</h3>
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value"><?= esc($patient['phone'] ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value"><?= esc($patient['email'] ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Address:</div>
                    <div class="info-value"><?= esc($patient['address'] ?? 'N/A') ?></div>
                </div>
            </div>

            <!-- Hospital Information -->
            <div class="info-card">
                <h3><i class="fas fa-hospital"></i> Hospital Information</h3>
                <div class="info-row">
                    <div class="info-label">Room:</div>
                    <div class="info-value"><?= esc($patient['room'] ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value"><?= esc($patient['status'] ?? 'Active') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Admitted:</div>
                    <div class="info-value">
                        <?php 
                        if (!empty($patient['created_at'])) {
                            $date = new DateTime($patient['created_at']);
                            echo $date->format('M d, Y H:i');
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <?php if ($emergency_contact): ?>
            <div class="info-card">
                <h3><i class="fas fa-phone-alt"></i> Emergency Contact</h3>
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value"><?= esc($emergency_contact['name']) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Relation:</div>
                    <div class="info-value"><?= esc($emergency_contact['relation']) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value"><?= esc($emergency_contact['phone']) ?></div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Medical Information -->
            <?php if ($medical_info): ?>
            <div class="info-card">
                <h3><i class="fas fa-heartbeat"></i> Medical Information</h3>
                <div class="info-row">
                    <div class="info-label">Blood Type:</div>
                    <div class="info-value"><?= esc($medical_info['blood_type'] ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Allergies:</div>
                    <div class="info-value"><?= esc($medical_info['allergies'] ?? 'None') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Conditions:</div>
                    <div class="info-value"><?= esc($medical_info['existing_condition'] ?? 'None') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Primary Physician:</div>
                    <div class="info-value"><?= esc($medical_info['primary_physician'] ?? 'N/A') ?></div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Insurance Information -->
            <?php if ($insurance): ?>
            <div class="info-card">
                <h3><i class="fas fa-shield-alt"></i> Insurance Information</h3>
                <div class="info-row">
                    <div class="info-label">Provider:</div>
                    <div class="info-value"><?= esc($insurance['provider']) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Policy Number:</div>
                    <div class="info-value"><?= esc($insurance['policy']) ?></div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Medical Notes -->
            <?php if (!empty($patient['medical_notes'])): ?>
            <div class="info-card full-width-card">
                <h3><i class="fas fa-notes-medical"></i> Medical Notes</h3>
                <div class="notes-section">
                    <?= nl2br(esc($patient['medical_notes'])) ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
