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
