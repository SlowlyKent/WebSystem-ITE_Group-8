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

        /* Sidebar styles are handled by _nurse_sidebar.php include */

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
            position: sticky;
            top: 20px;
            z-index: 100;
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

        /* Main Content Section */
        .main-content-section {
            margin-bottom: 20px;
        }

        .patient-assignments {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            min-height: 200px;
        }

        .patient-assignments h2 {
            color: #052719;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .assignments-placeholder {
            text-align: center;
            padding: 40px 20px;
            color: #879b93;
            background-color: rgba(185, 211, 201, 0.1);
            border-radius: 8px;
            border: 2px dashed #b9d3c9;
        }

        .vitals-section, .medication-section {
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            min-height: 250px;
        }

        .vitals-section h2, .medication-section h2 {
            color: #052719;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .vitals-placeholder, .medication-placeholder {
            text-align: center;
            padding: 30px 20px;
            color: #879b93;
            background-color: rgba(185, 211, 201, 0.1);
            border-radius: 6px;
            border: 1px dashed #b9d3c9;
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
        <?= $this->include('role_dashboard/nurse/_nurse_sidebar') ?>

        <!-- Main Content -->
        <main class="main">
            <header class="main-header">
                <div class="header-left">
                    <h1>Nurse Dashboard</h1>
                    <p>Welcome, <?= esc($user['name']) ?></p>
                </div>
                <div class="header-right">
                    <div class="profile-dropdown">
                        <button class="profile-btn" onclick="toggleProfileDropdown()">
                            <div class="profile-avatar"><i class="fas fa-user-nurse"></i></div>
                            <span><?= esc($user['name']) ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="profileDropdown">
                            <a href="<?= base_url('nurse/profile') ?>" class="dropdown-item">
                                <i class="fas fa-user-edit"></i> Edit Profile
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
                    <i class="fas fa-user-injured"></i>
                    <span>0</span>
                    <p>Patients Assigned Today</p>
                </div>
                <div class="card">
                    <i class="fas fa-pills"></i>
                    <span>0</span>
                    <p>Pending Medications</p>
                </div>
                <div class="card">
                    <i class="fas fa-clipboard-check"></i>
                    <span>0</span>
                    <p>Pending Lab Follow-ups</p>
                </div>
            </section>

            <!-- Main Content Section -->
            <div class="main-content-section">
                <div class="patient-assignments">
                    <h2>Today's Patient Assignments</h2>
                    <div class="assignments-placeholder">
                        <p>Patient assignments will be displayed here</p>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <div class="vitals-section">
                    <h2>Vitals Recording</h2>
                    <div class="vitals-placeholder">
                        <p>Vitals recording interface will be displayed here</p>
                    </div>
                </div>
                <div class="medication-section">
                    <h2>Medication Schedule</h2>
                    <div class="medication-placeholder">
                        <p>Medication schedule will be displayed here</p>
                    </div>
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
