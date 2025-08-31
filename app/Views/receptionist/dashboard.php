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
            --primary-color: #052719;
        }

        body {
            background-color: #b9d3c9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 20px;
            top: 20px;
            height: 100vh;
            width: 270px;
            border-radius: 20px;
            background: var(--primary-color);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            
        }

        .sidebar-header h4 {
            margin: 0;
            font-weight: 600;
        }

        .user-profile {
            text-align: center;
            padding: 20px;
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

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover, .nav-link.active, .btn-outline-light:hover{
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

        /*Profile button*/
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
            background: var(--primary-color);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            text-align: center;
            margin: auto;
            font-size: 1.5rem;
            color: white;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #00ff40ff;
        }

        .stat-label {
            color: #ffffffff;
            font-size: 1rem;
        }

        /* Widgets Grid */
        .widgets-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr; /* 3 equal parts = quarters */
            gap: 20px;
            margin-bottom: 25px;
        }

        .widget {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .widget-title {
            color: var(--primary-color);
            padding: 15px 20px;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .widget-body {
            padding: 20px;
            min-height: 250px;
        }

        .widget.large {
            grid-column: span 2;
        }

        .widget.small {
            grid-column: span 1;
        }

        /* Schedule Widget */
        .schedule-tabs {
            display: flex;
            margin-bottom: 15px;
        }

        .schedule-tab {
            flex: 1;
            height: 45px;
            padding: 10px;
            text-align: center;
            background: #e0e1e3ff;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .schedule-tab.active {
            background: var(--primary-color);
            color: white;
        }

        .schedule-content {
            min-height: 250px;
            background: #f7f7f7ff;
            border-radius: 10px;
            padding: 40px;
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
            <li>
                <a href="<?= base_url('dashboard') ?>" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fas fa-user-plus"></i>
                    Patient Registration
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar-check"></i>
                    Appointment Booking
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar-alt"></i>
                    Doctor/Nurse Schedule Viewer
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fas fa-credit-card"></i>
                    Billing & Payments
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fas fa-search"></i>
                    Patient Search & Lookup
                </a>
            </li>
            <li>
                <a href="#" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    Reports
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
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number"><?= $stats['totalPatients'] ?></div>
                <div class="stat-label">Patients Registered Today</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-number"><?= $stats['totalAppointments'] ?></div>
                <div class="stat-label">Appointments Today</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-number"><?= $stats['pendingPayments'] ?></div>
                <div class="stat-label">Pending Payments</div>
            </div>
        </div>

        <!-- Widgets Grid -->
        <div class="widgets-grid">

            <!-- Patient Registration Widget -->
            <div class="widget small">
                <div class="widget-title">
                    <i class="fas fa-user-plus"></i> Patient Registration
                </div>
                <div class="widget-body">
                    <div class="text-center text-muted">
                        <i class="fas fa-user-plus" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-2">Register new patients</p>
                    </div>
                </div>
            </div>
            <!-- Appointment Booking Widget -->
            <div class="widget small">
                <div class="widget-title">
                    <i class="fas fa-calendar-check"></i> Appointment Booking
                </div>
                <div class="widget-body">
                    <div class="text-center text-muted">
                        <i class="fas fa-calendar-check" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-2">Manage appointments</p>
                    </div>
                </div>
            </div>

            
            <!-- Patient Search & Lookup Widget -->
            <div class="widget small">
                <div class="widget-title">
                    <i class="fas fa-search"></i> Patient Search & Lookup
                </div>
                <div class="widget-body">
                    <div class="text-center text-muted">
                        <i class="fas fa-search" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-2">Find patient records</p>
                    </div>
                </div>
            </div>

            <!-- Doctor/Nurse Schedule Widget -->
            <div class="widget large">
                <div class="widget-title">
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

            <!-- Billing & Payments Widget -->
            <div class="widget small">
                <div class="widget-title">
                    <i class="fas fa-credit-card"></i> Billing & Payments
                </div>
                <div class="widget-body">
                    <div class="text-center text-muted">
                        <i class="fas fa-file-invoice-dollar" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-2">Billing information</p>
                    </div>
                </div>
            </div>

            <!-- Reports Widget -->
            <div class="widget small">
                <div class="widget-title">
                    <i class="fas fa-chart-bar"></i> Reports
                </div>
                <div class="widget-body">
                    <div class="text-center text-muted">
                        <i class="fas fa-chart-bar" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-2">Generate reports</p>
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