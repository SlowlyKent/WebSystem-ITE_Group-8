<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details - HMS</title>
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
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .sidebar-header h4 {
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background-color: #ccc;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #666;
        }

        .sidebar-header p {
            font-size: 12px;
            margin-bottom: 5px;
            color: white;
        }

        .sidebar-header small {
            font-size: 10px;
            opacity: 0.8;
            color: white;
        }

        .nav-menu ul {
            list-style: none;
        }

        .nav-menu li {
            margin-bottom: 3px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background-color 0.3s;
            font-size: 12px;
        }

        .nav-menu a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .nav-menu a.active {
            background-color: rgba(255,255,255,0.2);
        }

        .nav-menu i {
            margin-right: 8px;
            width: 14px;
            font-size: 12px;
        }

        .logout-section {
            position: absolute;
            bottom: 15px;
            left: 15px;
            right: 15px;
        }

        .logout-section a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            border: 1px solid white;
            border-radius: 6px;
            transition: background-color 0.3s;
            font-size: 12px;
        }

        .logout-section a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        /* Main Content */
        .main-content {
            margin-left: 300px;
            padding: 20px;
            min-height: 100vh;
        }

        .page-header {
            background-color: #052719;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            color: white;
            font-size: 24px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-primary {
            background-color: #b9d3c9;
            color: #052719;
        }

        .btn-primary:hover {
            background-color: #a8d5ba;
        }

        /* Patient Details */
        .patient-details {
            background-color: #052719;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .patient-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(255,255,255,0.2);
        }

        .patient-avatar {
            width: 80px;
            height: 80px;
            background-color: #b9d3c9;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #052719;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .detail-section {
            background-color: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #b9d3c9;
        }

        .detail-section h3 {
            color: white;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .detail-label {
            font-weight: bold;
            color: #ccc;
            min-width: 120px;
            margin-right: 15px;
        }

        .detail-value {
            color: white;
            flex: 1;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 10px;
            }
            
            .sidebar {
                display: none;
            }
            
            .details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>HMS</h4>
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <p>Admin User</p>
            <small>Hospital Administrator Dashboard</small>
        </div>

        <nav class="nav-menu">
            <ul>
                <li>
                    <a href="<?= base_url('dashboard') ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('patients') ?>" class="active">
                        <i class="fas fa-user-plus"></i>
                        Patient Registration & EHR
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-credit-card"></i>
                        Billing & Payment
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-chart-bar"></i>
                        Reports & Analytics
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-flask"></i>
                        Laboratory Management
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-pills"></i>
                        Pharmacy & Inventory
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-database"></i>
                        Database Status
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('user-management') ?>">
                        <i class="fas fa-users-cog"></i>
                        User Management
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-calendar-alt"></i>
                        Scheduling
                    </a>
                </li>
            </ul>
        </nav>

        <div class="logout-section">
            <a href="<?= base_url('logout') ?>">
                <i class="fas fa-sign-out-alt"></i>
                Log-out
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1>Patient Details</h1>
            <div class="action-buttons">
                <a href="<?= base_url('patients') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <a href="<?= base_url('patients/edit/' . $patient['id']) ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Patient
                </a>
            </div>
        </div>

        <div class="patient-details">
            <div class="patient-header">
                <div class="patient-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h2 style="color: white;"><?= esc($patient['first_name']) ?> <?= esc($patient['middle_name']) ?> <?= esc($patient['last_name']) ?></h2>
                <p style="color: #ccc;">Patient ID: #<?= $patient['id'] ?></p>
                <span class="status-badge <?= $patient['status'] === 'active' ? 'status-active' : 'status-inactive' ?>">
                    <?= ucfirst($patient['status']) ?>
                </span>
            </div>

            <div class="details-grid">
                <!-- Personal Information -->
                <div class="detail-section">
                    <h3><i class="fas fa-user"></i> Personal Information</h3>
                    <div class="detail-row">
                        <span class="detail-label">First Name:</span>
                        <span class="detail-value"><?= esc($patient['first_name']) ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Middle Name:</span>
                        <span class="detail-value"><?= esc($patient['middle_name']) ?: '—' ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Last Name:</span>
                        <span class="detail-value"><?= esc($patient['last_name']) ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date of Birth:</span>
                        <span class="detail-value"><?= date('M d, Y', strtotime($patient['date_of_birth'])) ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Gender:</span>
                        <span class="detail-value"><?= ucfirst($patient['gender']) ?></span>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="detail-section">
                    <h3><i class="fas fa-phone"></i> Contact Information</h3>
                    <div class="detail-row">
                        <span class="detail-label">Phone:</span>
                        <span class="detail-value"><?= esc($patient['phone']) ?: '—' ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value"><?= esc($patient['email']) ?: '—' ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Address:</span>
                        <span class="detail-value"><?= esc($patient['address']) ?: '—' ?></span>
                    </div>
                </div>

                <!-- Medical Information -->
                <div class="detail-section">
                    <h3><i class="fas fa-stethoscope"></i> Medical Information</h3>
                    <div class="detail-row">
                        <span class="detail-label">Status:</span>
                        <span class="detail-value">
                            <span class="status-badge <?= $patient['status'] === 'active' ? 'status-active' : 'status-inactive' ?>">
                                <?= ucfirst($patient['status']) ?>
                            </span>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Room:</span>
                        <span class="detail-value"><?= esc($patient['room']) ?: '—' ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Medical Notes:</span>
                        <span class="detail-value"><?= esc($patient['medical_notes']) ?: '—' ?></span>
                    </div>
                </div>

                <!-- System Information -->
                <div class="detail-section">
                    <h3><i class="fas fa-info-circle"></i> System Information</h3>
                    <div class="detail-row">
                        <span class="detail-label">Created:</span>
                        <span class="detail-value"><?= date('M d, Y H:i', strtotime($patient['created_at'])) ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Last Updated:</span>
                        <span class="detail-value"><?= date('M d, Y H:i', strtotime($patient['updated_at'])) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
