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
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
        }

        .top-bar {
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

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
            margin-bottom: 25px;
        }

        .stat-card {
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
        }
    </style>
</head>
<body>
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
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
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
                </div>
            </div>
        </div>

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
                </div>
            </div>
        </div>
    </div>

    <script>
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
    </script>
</body>
</html>
