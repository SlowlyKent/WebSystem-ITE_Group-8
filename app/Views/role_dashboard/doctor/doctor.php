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
            height: calc(100vh - 30px);
            position: fixed;
            left: 15px;
            top: 15px;
            z-index: 1000;
            overflow-y: auto;
        }

        /* Main Content */
        .main {
            flex: 1;
            padding: 40px 40px 40px 340px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-height: 100vh;
            width: 100%;
        }

        .main-header {
            background-color: #81c798;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 15px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
        }

        .header-left h1 {
            color: #052719;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header-left p {
            color: #052719;
            font-size: 14px;
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: rgba(255,255,255,0.1);
            color: #052719;
            border: none;
            padding: 8px 12px;
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
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }

        .card {
            background: #052719;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: #fafafa;
        }

        .card i {
            font-size: 30px;
            margin-bottom: 10px;
            color: #00ff95;
        }

        .card span {
            display: block;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #00ff95;
        }

        .card:hover {
            background: #0f6b45;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .appointments-section, .patient-notes-section {
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .appointments-section h2, .patient-notes-section h2 {
            color: #052719;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .appointments-placeholder, .notes-placeholder {
            text-align: center;
            padding: 20px;
            color: #879b93;
            background-color: rgba(255,255,255,0.1);
            border-radius: 6px;
        }

        .appointments-placeholder i {
            font-size: 28px;
            margin-bottom: 8px;
            color: #b9d3c9;
        }

        /* Schedule List Styles */
        .schedule-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .schedule-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #00ff95;
        }

        .schedule-time {
            font-weight: bold;
            color: #052719;
            min-width: 100px;
            font-size: 14px;
        }

        .schedule-details {
            flex: 1;
        }

        .schedule-details h4 {
            margin: 0 0 4px 0;
            color: #052719;
            font-size: 14px;
        }

        .schedule-details p {
            margin: 0 0 6px 0;
            color: #666;
            font-size: 12px;
        }

        .schedule-type, .schedule-location {
            display: inline-block;
            background: #e9ecef;
            color: #495057;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            margin-right: 6px;
        }

        .schedule-status {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            min-width: 80px;
        }

        .status-scheduled {
            background: #fff3cd;
            color: #856404;
        }

        .status-in_progress {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        /* Upcoming Schedules */
        .upcoming-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .upcoming-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .upcoming-date {
            background: #052719;
            color: white;
            padding: 8px;
            border-radius: 6px;
            text-align: center;
            min-width: 50px;
            font-size: 12px;
            font-weight: bold;
        }

        .upcoming-details h5 {
            margin: 0 0 4px 0;
            color: #052719;
            font-size: 13px;
        }

        .upcoming-details p {
            margin: 0 0 4px 0;
            color: #666;
            font-size: 11px;
        }

        .upcoming-type {
            background: #e9ecef;
            color: #495057;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 10px;
        }

        /* Sidebar specific responsive adjustments */
        @media (max-width: 992px) {
            .sidebar nav ul {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
            }

            .sidebar nav li {
                flex: 1;
                min-width: 150px;
                text-align: center;
            }

            .sidebar .profile {
                flex-direction: row;
                align-items: center;
                justify-content: center;
                gap: 15px;
                margin-bottom: 20px;
            }

            .sidebar .avatar {
                width: 60px;
                height: 60px;
                margin-bottom: 0;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                padding: 10px;
            }

            .sidebar nav ul {
                flex-direction: column;
                gap: 5px;
            }

            .sidebar nav li {
                min-width: auto;
                padding: 8px;
                font-size: 13px;
            }

            .sidebar .profile {
                flex-direction: column;
                gap: 10px;
            }

            .sidebar .avatar {
                width: 50px;
                height: 50px;
            }
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main {
                padding: 20px 20px 20px 320px;
            }
        }

        @media (max-width: 992px) {
            .dashboard {
                padding: 15px;
                flex-direction: column;
            }
            
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                margin: 0 0 20px 0;
                left: 0;
                top: 0;
                border-radius: 10px;
            }

            .main {
                width: 100%;
                padding: 15px;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .main-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        @media (max-width: 768px) {
            .dashboard {
                padding: 10px;
            }

            .main {
                padding: 10px;
                gap: 15px;
            }

            .main-header {
                padding: 15px;
            }

            .stats {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                gap: 15px;
            }

            .card {
                padding: 15px;
            }

            .card i {
                font-size: 24px;
            }

            .card span {
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            .dashboard {
                padding: 5px;
            }

            .main {
                padding: 5px;
            }

            .main-header {
                padding: 12px;
            }

            .header-left h1 {
                font-size: 18px;
            }

            .header-left p {
                font-size: 12px;
            }

            .stats {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .card {
                padding: 12px;
            }

            .card i {
                font-size: 20px;
            }

            .card span {
                font-size: 16px;
            }

            .profile-btn {
                padding: 6px 10px;
                font-size: 12px;
            }

            .profile-avatar {
                width: 24px;
                height: 24px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar Navigation -->
        <?= $this->include('role_dashboard/doctor/_doctor_sidebar') ?>

        <!-- Main Content -->
        <main class="main">
            <header class="main-header">
                <div class="header-left">
                    <h1>Doctor Dashboard</h1>
                    <p>Welcome, Dr. <?= esc($user['name']) ?></p>
                </div>
                <div class="header-right">
                    <div class="profile-dropdown">
                        <button class="profile-btn" onclick="toggleProfileDropdown()">
                            <div class="profile-avatar"><i class="fas fa-user-md"></i></div>
                            <span>Dr. <?= esc($user['name']) ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="profileDropdown">
                            <a href="<?= base_url('doctor/profile') ?>" class="dropdown-item">
                                <i class="fas fa-user-edit"></i> Edit Profile
                            </a>
                            <a href="<?= base_url('doctor/settings') ?>" class="dropdown-item">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('logout') ?>" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Stats -->
            <section class="stats">
                <div class="card">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span><?= isset($scheduleStats['today_total']) ? $scheduleStats['today_total'] : 0 ?></span>
                    <p>Today's Schedules</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-clock"></i>
                    <span><?= isset($scheduleStats['today_pending']) ? $scheduleStats['today_pending'] : 0 ?></span>
                    <p>Pending Today</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-check-circle"></i>
                    <span><?= isset($scheduleStats['today_completed']) ? $scheduleStats['today_completed'] : 0 ?></span>
                    <p>Completed Today</p>
                </div>
                <div class="card">
                    <i class="fas fa-calendar-week"></i>
                    <span><?= isset($scheduleStats['upcoming_week']) ? $scheduleStats['upcoming_week'] : 0 ?></span>
                    <p>This Week</p>
                </div>
            </section>

            <!-- Content Grid -->
            <div class="content-grid">
                <div class="appointments-section">
                    <h2><i class="fas fa-calendar-check"></i> Today's Schedules</h2>
                    <?php if (!empty($todaySchedules)): ?>
                        <div class="schedule-list">
                            <?php foreach ($todaySchedules as $schedule): ?>
                                <div class="schedule-item">
                                    <div class="schedule-time">
                                        <?= date('H:i', strtotime($schedule['start_time'])) ?> - <?= date('H:i', strtotime($schedule['end_time'])) ?>
                                    </div>
                                    <div class="schedule-details">
                                        <h4><?= esc($schedule['description']) ?></h4>
                                        <span class="schedule-type"><?= ucfirst($schedule['schedule_type']) ?></span>
                                        <?php if ($schedule['location']): ?>
                                            <span class="schedule-location"><i class="fas fa-map-marker-alt"></i> <?= esc($schedule['location']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="appointments-placeholder">
                            <i class="fas fa-calendar-alt"></i>
                            <p>No schedules for today</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="patient-notes-section">
                    <h2><i class="fas fa-calendar-week"></i> Upcoming Schedules</h2>
                    <?php if (!empty($upcomingSchedules)): ?>
                        <div class="upcoming-list">
                            <?php foreach ($upcomingSchedules as $schedule): ?>
                                <div class="upcoming-item">
                                    <div class="upcoming-date">
                                        <?= date('M d', strtotime($schedule['schedule_date'])) ?>
                                    </div>
                                    <div class="upcoming-details">
                                        <h5><?= esc($schedule['description']) ?></h5>
                                        <p><?= date('H:i', strtotime($schedule['start_time'])) ?> - <?= date('H:i', strtotime($schedule['end_time'])) ?></p>
                                        <span class="upcoming-type"><?= ucfirst($schedule['schedule_type']) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="notes-placeholder">
                            <p>No upcoming schedules</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
        }
        
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
