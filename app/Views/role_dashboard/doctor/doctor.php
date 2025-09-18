<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - HMS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/docnurse.css') ?>">
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
