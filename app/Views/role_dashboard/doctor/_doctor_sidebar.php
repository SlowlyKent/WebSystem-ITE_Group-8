<div class="sidebar">
    <div class="sidebar-header">
        <h4>HMS</h4>
        <div class="user-avatar">
            <i class="fas fa-user-md"></i>
        </div>
        <p><?= session()->get('fullName') ?: 'Doctor' ?></p>
        <small>Doctor Dashboard</small>
    </div>

    <nav class="nav-menu">
        <ul>
            <li>
                <a href="<?= base_url('doctor/dashboard') ?>" <?= uri_string() === 'doctor/dashboard' ? 'class="active"' : '' ?>>
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="<?= base_url('doctor/patients') ?>" <?= uri_string() === 'doctor/patients' ? 'class="active"' : '' ?>>
                    <i class="fas fa-user-injured"></i>
                    Patient Records
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-calendar-check"></i>
                    Appointments
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-prescription-bottle-alt"></i>
                    Prescriptions
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-flask"></i>
                    Lab Results
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-notes-medical"></i>
                    Medical Notes
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-chart-line"></i>
                    Patient Analytics
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-calendar-alt"></i>
                    Schedule
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
