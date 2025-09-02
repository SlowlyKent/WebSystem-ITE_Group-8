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

<<<<<<< HEAD
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
        }

        .sidebar-header small {
            font-size: 10px;
            opacity: 0.8;
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
=======
        :root {
            --sidebar-width: 280px;
            --primary-color: #667eea;
            --secondary-color: #764ba2; 
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h4 {
            margin: 0;
            font-weight: 600;
        }

        .user-profile {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2rem;
        }

        .role-badge {
            background: rgba(255,255,255,0.2);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .nav-menu {
            padding: 20px 0;
            list-style: none;
        }

        .nav-item {
            list-style: none;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left-color: white;
        }

        .nav-link i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        .logout-btn {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-outline-light {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline-light:hover {
            background: white;
            color: var(--primary-color);
        }

        .btn-outline-primary {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.875rem;
        }

        .w-100 {
            width: 100%;
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
        }

        /* Main Content */
        .main-content {
<<<<<<< HEAD
            margin-left: 300px;
=======
            margin-left: var(--sidebar-width);
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
            padding: 20px;
            min-height: 100vh;
        }

<<<<<<< HEAD
        .main-header {
            background-color: #052719;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
=======
        .top-bar {
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

<<<<<<< HEAD
        .header-left h1 {
            color: white;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header-left p {
            color: #ccc;
            font-size: 16px;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: rgba(255,255,255,0.1);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .profile-btn:hover {
            background-color: rgba(255,255,255,0.2);
        }

        .profile-avatar {
            width: 30px;
            height: 30px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #052719;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            min-width: 200px;
            z-index: 1000;
            display: none;
            overflow: hidden;
            margin-top: 5px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
            font-size: 14px;
        }

        .dropdown-item:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .dropdown-divider {
            height: 1px;
            background-color: rgba(255,255,255,0.2);
            margin: 5px 0;
        }

        /* Stats Section */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
=======
        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
            margin-bottom: 25px;
        }

        .stat-card {
<<<<<<< HEAD
            background-color: #052719;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-icon {
            font-size: 20px;
            color: white;
            margin-bottom: 8px;
        }

        .stat-info h3 {
            font-size: 20px;
            color: white;
            margin-bottom: 3px;
        }

        .stat-info p {
            color: #ccc;
            font-size: 12px;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .calendar-section, .lab-status-section {
            background-color: #052719;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .calendar-section h2, .lab-status-section h2 {
            color: white;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .calendar-placeholder, .lab-placeholder {
            text-align: center;
            padding: 30px;
            color: #ccc;
            background-color: rgba(255,255,255,0.1);
            border-radius: 6px;
        }

        .calendar-placeholder i {
            font-size: 36px;
            margin-bottom: 10px;
            color: #ccc;
        }

        .lab-placeholder {
            padding: 20px;
=======
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.patients { background: var(--primary-color); }
        .stat-icon.appointments { background: var(--success-color); }
        .stat-icon.labs { background: var(--warning-color); }
        .stat-icon.revenue { background: var(--danger-color); }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        /* Widgets Grid */
        .widgets-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .widget {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .widget-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            font-weight: 600;
        }

        .widget-body {
            padding: 20px;
            min-height: 200px;
        }

        .widget.large {
            grid-column: span 2;
        }

        .widget.small {
            grid-column: span 1;
        }

        /* Calendar Widget */
        .calendar-widget {
            min-height: 300px;
        }

        /* Schedule Widget */
        .schedule-tabs {
            display: flex;
            margin-bottom: 15px;
        }

        .schedule-tab {
            flex: 1;
            padding: 10px;
            text-align: center;
            background: #f8f9fa;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .schedule-tab.active {
            background: var(--primary-color);
            color: white;
        }

        .schedule-content {
            min-height: 150px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-muted { color: #6c757d; }
        .mt-3 { margin-top: 1rem; }
        .mt-2 { margin-top: 0.5rem; }

        /* Responsive */
        @media (max-width: 1200px) {
            .widgets-grid {
                grid-template-columns: 1fr;
            }
            .widget.large {
                grid-column: span 1;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
        }
    </style>
</head>
<body>
<<<<<<< HEAD
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>HMS</h4>
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <p><?= $user['fullName'] ?></p>
            <small>Hospital Administrator Dashboard</small>
        </div>

        <nav class="nav-menu">
            <ul>
                <li>
                    <a href="<?= base_url('dashboard') ?>" class="active">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('patients') ?>">
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
                <?php if (in_array($user['role'], ['admin', 'it_staff'])): ?>
                <li>
                    <a href="<?= base_url('user-management') ?>">
                        <i class="fas fa-users-cog"></i>
                        User Management
                    </a>
                </li>
                <?php endif; ?>
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
=======
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>HMS</h4>
        </div>

        <div class="user-profile">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <h6><?= $user['fullName'] ?></h6>
            <div class="role-badge">
                <?= ucfirst(str_replace('_', ' ', $user['role'])) ?>
            </div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="<?= base_url('dashboard') ?>" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-user-plus"></i>
                    Patient Registration & EHR
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-credit-card"></i>
                    Billing & Payment Processing
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    Reports & Analytics
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-flask"></i>
                    Laboratory Management
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-pills"></i>
                    Pharmacy & Inventory Control
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-database"></i>
                    Centralized Database Status
                </a>
            </li>
            <?php if (in_array($user['role'], ['admin', 'it_staff'])): ?>
            <li class="nav-item">
                <a href="<?= base_url('user-management') ?>" class="nav-link">
                    <i class="fas fa-users-cog"></i>
                    User & Access Management
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar-alt"></i>
                    Doctor/Nurse Scheduling
                </a>
            </li>
        </ul>

        <div class="logout-btn">
            <a href="<?= base_url('logout') ?>" class="btn btn-outline-light w-100">
                <i class="fas fa-sign-out-alt"></i> Log-out
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
<<<<<<< HEAD
        <header class="main-header">
            <div class="header-left">
                <h1>Dashboard</h1>
                <p>Welcome, <?= $user['fullName'] ?></p>
            </div>
            <div class="header-right">
                <div class="profile-dropdown">
                    <button class="profile-btn" onclick="toggleProfileDropdown()">
                        <div class="profile-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span><?= $user['fullName'] ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="profileDropdown">
                        <a href="<?= base_url('dashboard/profile') ?>" class="dropdown-item">
                            <i class="fas fa-user-edit"></i>
                            Edit Profile
                        </a>
                        <a href="<?= base_url('dashboard/settings') ?>" class="dropdown-item">
                            <i class="fas fa-cog"></i>
                            Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('logout') ?>" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Statistics Cards -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $stats['totalPatients'] ?></h3>
                    <p>Patients Today</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $stats['totalAppointments'] ?></h3>
                    <p>Appointments</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $stats['pendingLabs'] ?></h3>
                    <p>Pending Labs</p>
=======
        <!-- Top Bar -->
        <div class="top-bar">
            <h1 class="page-title">Dashboard</h1>
            <div class="user-info">
                <span>Welcome, <?= $user['fullName'] ?></span>
                <a href="<?= base_url('dashboard/profile') ?>" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-user"></i> Profile
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon patients">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number"><?= $stats['totalPatients'] ?></div>
                <div class="stat-label">Patients Today</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon appointments">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-number"><?= $stats['totalAppointments'] ?></div>
                <div class="stat-label">Appointments</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon labs">
                    <i class="fas fa-flask"></i>
                </div>
                <div class="stat-number"><?= $stats['pendingLabs'] ?></div>
                <div class="stat-label">Pending Labs</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon revenue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-number">$<?= number_format($stats['revenue']) ?></div>
                <div class="stat-label">Revenue</div>
            </div>
        </div>

        <!-- Widgets Grid -->
        <div class="widgets-grid">
            <!-- Calendar Widget -->
            <div class="widget large">
                <div class="widget-header">
                    <i class="fas fa-calendar"></i> Calendar
                </div>
                <div class="widget-body calendar-widget">
                    <div class="text-center text-muted">
                        <i class="fas fa-calendar-alt" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="mt-3">Calendar widget will be implemented here</p>
                    </div>
                </div>
            </div>

            <!-- Billing Widget -->
            <div class="widget small">
                <div class="widget-header">
                    <i class="fas fa-credit-card"></i> Billing
                </div>
                <div class="widget-body">
                    <div class="text-center text-muted">
                        <i class="fas fa-file-invoice-dollar" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-2">Billing information</p>
                    </div>
                </div>
            </div>

            <!-- Laboratory Status Widget -->
            <div class="widget small">
                <div class="widget-header">
                    <i class="fas fa-flask"></i> Laboratory Status
                </div>
                <div class="widget-body">
                    <div class="text-center text-muted">
                        <i class="fas fa-microscope" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-2">Lab status updates</p>
                    </div>
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
                </div>
            </div>
        </div>

<<<<<<< HEAD
        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Calendar Section -->
            <div class="calendar-section">
                <h2><i class="fas fa-calendar"></i> Calendar</h2>
                <div class="calendar-placeholder">
                    <i class="fas fa-calendar-alt"></i>
                    <p>Calendar widget will be implemented here</p>
                </div>
            </div>

            <!-- Laboratory Status Section -->
            <div class="lab-status-section">
                <h2><i class="fas fa-flask"></i> Laboratory Status</h2>
                <div class="lab-placeholder">
                    <p>Lab status updates</p>
=======
        <!-- Bottom Row Widgets -->
        <div class="widgets-grid">
            <!-- Doctor/Nurse Schedule Widget -->
            <div class="widget large">
                <div class="widget-header">
                    <i class="fas fa-calendar-alt"></i> Doctor/Nurse Schedule
                </div>
                <div class="widget-body">
                    <div class="schedule-tabs">
                        <button class="schedule-tab active">Doctor</button>
                        <button class="schedule-tab">Nurse</button>
                    </div>
                    <div class="schedule-content">
                        <div class="text-center text-muted">
                            <i class="fas fa-user-md" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="mt-2">Schedule widget</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pharmacy & Inventory Status Widget -->
            <div class="widget large">
                <div class="widget-header">
                    <i class="fas fa-pills"></i> Pharmacy & Inventory Status
                </div>
                <div class="widget-body">
                    <div class="text-center text-muted">
                        <i class="fas fa-pills" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-2">Pharmacy & inventory information</p>
                    </div>
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
                </div>
            </div>
        </div>
    </div>

    <script>
<<<<<<< HEAD
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const profileBtn = document.querySelector('.profile-btn');
            
            if (!profileBtn.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
=======
        // Schedule tabs functionality
        document.querySelectorAll('.schedule-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.schedule-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Flash message auto-hide
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
    </script>
</body>
</html>
