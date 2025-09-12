<?= $this->extend('role_dashboard/receptionist/layout') ?>
<?= $this->section('content') ?>

<style>
    .inside-box {
        background-color: white;
        min-height: 250px;
        border-radius: 10px;
        padding: 15px;
    }
    .appointments-widget-table {
        width: 100%;
        border-collapse: collapse;
    }

    .appointments-widget-table td {
        padding: 8px 0;
        border-bottom: 1px solid #ddd;
        color: black;
    }

    .appointments-widget-table tr:last-child td {
        border-bottom: none;
    }

    .appointments-widget-table .text-right {
        text-align: right;
        font-weight: 600;
    }

    /* Patient Registration */
    .latest-patients {
        margin-top: 15px;
    }

    .latest-patients h4 {
        font-size: 0.95rem;
        margin-bottom: 8px;
        color: #052719;
    }

    .latest-patients ul {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 0.9rem;
    }

    .latest-patients li {
        padding: 6px 0;
        border-bottom: 1px solid #eee;
    }

    .latest-patients li span {
        color: gray;
        font-size: 0.8rem;
    }

    .latest-patients li.empty {
        color: gray;
        font-style: italic;
    }

    /* Patient Search and Lookup */
    .widget-search-form {
        display: flex;
        gap: 8px;
    }

    .widget-search-form input[type="text"] {
        flex: 1;
        padding: 15px 20px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    .searchbar {
        margin: 20px 0;
    }

    .widget-search-form button {
        padding: 15px 20px;
        background: #052719;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: background 0.3s ease;
    }

    .widget-search-form button:hover {
        background: #094d2f;
    }

/* Doctor/Nurse Schedule Viewer Table */
    .schedule-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background: white; 
        font-size: 0.95rem;
        border: 2px solid #052719;
    }

    .schedule-table th,
    .schedule-table td {
        border: 1px solid #052719;
        padding: 10px;
        text-align: left;
        color: #052719;
    }

    .schedule-table th {
        background: #f5f5f5;
        font-weight: bold;
    }

</style>


<!-- Patient Search and lookup -->
    <div class="searchbar">
        <form method="get" action="<?= base_url('receptionist/patientsearch_lookup') ?>" class="widget-search-form">
            <input type="text" name="keyword" placeholder="Search by name, ID, or contact" required>
            <button type="submit">Search</button>
        </form>
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
    <!-- Design only with Sample data -->
    <div class="widget small">
        <div class="widget-title">
            <i class="fas fa-user-plus"></i> Patient Registration
        </div>
        <div class="widget-body">
            <div class="inside-box">
                <table class="appointments-widget-table">
                    <tr>
                        <td>Patients Registered Today</td>
                        <td class="text-right"><?= $stats['totalPatients'] ?></td>
                    </tr>
                    <tr>
                        <td>Total Patients</td>
                        <td class="text-right"><?= $stats['allPatients'] ?? 0 ?></td>
                    </tr>
                    <tr>
                        <td>New Patients This Week</td>
                        <td class="text-right"><?= $stats['weeklyPatients'] ?? 0 ?></td>
                    </tr>
                </table>
                <hr>
                <div class="latest-patients">
                    <h4>Latest Registered</h4>
                    <ul>
                        <?php if (!empty($latestPatients)): ?>
                            <?php foreach ($latestPatients as $p): ?>
                                <li>
                                    <?= esc($p['fullName']) ?> 
                                    <span>(<?= esc($p['id']) ?>)</span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="empty">No recent registrations.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Booking Widget -->
    <!-- Fully connected with controller, model, view, migrations -->
    <div class="widget small">
        <div class="widget-title">
            <i class="fas fa-calendar-check"></i> Appointments
        </div>
        <div class="widget-body">
            <div class="inside-box">
                <table class="appointments-widget-table">
                    <tr>
                        <td>Today’s Appointments</td>
                        <td class="text-right"><?= !empty($todayAppointments) ? count($todayAppointments) : 0 ?></td>
                    </tr>
                    <tr>
                        <td>Upcoming Appointments</td>
                        <td class="text-right"><?= !empty($upcomingAppointments) ? count($upcomingAppointments) : 0 ?></td>
                    </tr>
                    <tr>
                        <td>Finished Appointments</td>
                        <td class="text-right"><?= !empty($finishedAppointments) ? count($finishedAppointments) : 0 ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
        
    <!-- Billing & Payments Widget -->
    <div class="widget small">
        <div class="widget-title">
            <i class="fas fa-credit-card"></i> Billing & Payments
        </div>
        <div class="widget-body">
            <div class="inside-box">
            <table class="appointments-widget-table">
                <tr>
                    <td>Unpaid</td>
                    <td class="text-right"><?= $stats['unpaid'] ?? 11 ?></td>
                </tr>
                <tr>
                    <td>Pending</td>
                    <td class="text-right"><?= $stats['pending'] ?? 0 ?></td>
                </tr>
                <tr>
                    <td>Paid</td>
                    <td class="text-right"><?= $stats['Pending'] ?? 0 ?></td>
                </tr>
            </table>
            </div>
        </ul>
        </div>
    </div>

    <!-- Doctor/Nurse Schedule Widget -->
    <!-- Design only with Sample data -->
    <div class="widget large">
        <div class="widget-title">
            <i class="fas fa-calendar-alt"></i> Doctor/Nurse Schedule
        </div>
        <div class="widget-body">
            <div class="schedule-tabs">
                <button class="schedule-tab active" data-target="doctor">Doctor</button>
                <button class="schedule-tab" data-target="nurse">Nurse</button>
            </div>

            <!-- Doctor Schedule -->
            <div id="doctor" class="schedule-content active">
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Availability</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($doctorSchedule)): ?>
                            <?php 
                            $found = false;
                            foreach ($doctorSchedule as $doc): 
                                if (stripos($doc['days'], $today) !== false): 
                                    $found = true; ?>
                                    <tr>
                                        <td><?= esc($doc['name']) ?></td>
                                        <td>Available Today (<?= esc($today) ?>)</td>
                                    </tr>
                                <?php endif;
                            endforeach; ?>
                            <?php if (!$found): ?>
                                <tr><td colspan="2">No doctors available today.</td></tr>
                            <?php endif; ?>
                        <?php else: ?>
                            <tr><td colspan="2">No doctor schedules available.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Nurse Schedule -->
            <div id="nurse" class="schedule-content" style="display:none;">
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Nurse</th>
                            <th>Availability</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($nurseSchedule)): ?>
                            <?php 
                            $found = false;
                            foreach ($nurseSchedule as $nurse): 
                                if (stripos($nurse['days'], $today) !== false): 
                                    $found = true; ?>
                                    <tr>
                                        <td><?= esc($nurse['name']) ?></td>
                                        <td>Available Today (<?= esc($today) ?>)</td>
                                    </tr>
                                <?php endif;
                            endforeach; ?>
                            <?php if (!$found): ?>
                                <tr><td colspan="2">No nurses available today.</td></tr>
                            <?php endif; ?>
                        <?php else: ?>
                            <tr><td colspan="2">No nurse schedules available.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Reports Widget -->
    <div class="widget small">
        <div class="widget-title">
            <i class="fas fa-chart-bar"></i> Reports
        </div>
        <div class="widget-body">
            <div class="reports-widget">
                <div class="inside-box">
                    <table class="appointments-widget-table">
                        <tr>
                            <td>Total Patients</td>
                            <td class="text-right"><?= $report['totalPatients'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Paid</td>
                            <td class="text-right"><?= $report['paidBills'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Pending</td>
                            <td class="text-right"><?= $report['pendingBills'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Overdue</td>
                            <td class="text-right"><?= $report['overdue'] ?? 0 ?></td>
                        </tr>
                    </table>
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

<?= $this->endSection() ?>
