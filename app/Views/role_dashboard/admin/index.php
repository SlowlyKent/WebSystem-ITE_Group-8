<?= $this->extend('role_dashboard/admin/_layout') ?>

<?= $this->section('content') ?>
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
            <p style="color: #b9d3c9; margin-top: 5px;">Welcome back, <?= esc($user['fullName']) ?></p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon patients">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3><?= esc($stats['totalPatients']) ?></h3>
                <p>Total Patients</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon appointments">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3><?= esc($stats['totalAppointments']) ?></h3>
                <p>Appointments Today</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon labs">
                <i class="fas fa-flask"></i>
            </div>
            <div class="stat-info">
                <h3><?= esc($stats['pendingLabs']) ?></h3>
                <p>Pending Labs</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon users">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="stat-info">
                <h3><?= isset($stats['totalUsers']) ? esc($stats['totalUsers']) : '0' ?></h3>
                <p>System Users</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
        <div class="action-cards">
            <a href="<?= base_url('patients') ?>" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3>Patient Registration</h3>
                <p>Register new patients and manage EHR</p>
            </a>

            <a href="<?= base_url('user-management') ?>" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <h3>User Management</h3>
                <p>Manage system users and permissions</p>
            </a>

            <a href="#" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3>Reports & Analytics</h3>
                <p>View system reports and analytics</p>
            </a>

            <a href="#" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-database"></i>
                </div>
                <h3>System Status</h3>
                <p>Monitor database and system health</p>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="recent-activity">
        <h2><i class="fas fa-clock"></i> Recent Activity</h2>
        <div class="activity-container">
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="activity-content">
                    <p><strong>New patient registered</strong></p>
                    <small>2 hours ago</small>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="activity-content">
                    <p><strong>Appointment scheduled</strong></p>
                    <small>4 hours ago</small>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <div class="activity-content">
                    <p><strong>Lab results updated</strong></p>
                    <small>6 hours ago</small>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
