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
            color: #b9d3c9;
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
            color: #b9d3c9;
            font-size: 12px;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .appointments-section, .patient-notes-section {
            background-color: #052719;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .appointments-section h2, .patient-notes-section h2 {
            color: white;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .appointments-placeholder, .notes-placeholder {
            text-align: center;
            padding: 30px;
            color: #b9d3c9;
            background-color: rgba(255,255,255,0.1);
            border-radius: 6px;
        }

        .appointments-placeholder i {
            font-size: 36px;
            margin-bottom: 10px;
            color: #b9d3c9;
        }

        .notes-placeholder {
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <?= $this->include('role_dashboard/doctor/_doctor_sidebar') ?>

    <!-- Main Content -->
    <div class="main-content">
        <header class="main-header">
            <div class="header-left">
                <h1>Doctor Dashboard</h1>
                <p>Welcome, Dr. <?= $user['name'] ?></p>
            </div>
            <div class="header-right">
                <div class="profile-dropdown">
                    <button class="profile-btn" onclick="toggleProfileDropdown()">
                        <div class="profile-avatar">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <span>Dr. <?= $user['name'] ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="profileDropdown">
                        <a href="<?= base_url('doctor/profile') ?>" class="dropdown-item">
                            <i class="fas fa-user-edit"></i>
                            Edit Profile
                        </a>
                        <a href="<?= base_url('doctor/settings') ?>" class="dropdown-item">
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
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>8</h3>
                    <p>Today's Appointments</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-injured"></i>
                </div>
                <div class="stat-info">
                    <h3>24</h3>
                    <p>Active Patients</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <div class="stat-info">
                    <h3>5</h3>
                    <p>Pending Lab Results</p>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Appointments Section -->
            <div class="appointments-section">
                <h2><i class="fas fa-calendar-check"></i> Today's Appointments</h2>
                <div class="appointments-placeholder">
                    <i class="fas fa-calendar-alt"></i>
                    <p>Appointment schedule will be displayed here</p>
                </div>
            </div>

            <!-- Patient Notes Section -->
            <div class="patient-notes-section">
                <h2><i class="fas fa-notes-medical"></i> Recent Notes</h2>
                <div class="notes-placeholder">
                    <p>Recent patient notes and updates</p>
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