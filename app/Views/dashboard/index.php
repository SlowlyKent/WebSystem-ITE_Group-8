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
        }

        /* Main Content */
        .main-content {
            margin-left: 300px;
            padding: 20px;
            min-height: 100vh;
        }

        .main-header {
            background-color: #052719;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

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
            margin-bottom: 25px;
        }

        .stat-card {
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
                    <a href="<?= base_url('pharmacy') ?>">
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
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
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
                </div>
            </div>
        </div>

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
                </div>
            </div>
        </div>
    </div>

    <script>
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
    </script>
</body>
</html>
