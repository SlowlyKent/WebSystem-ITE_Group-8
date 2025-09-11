
<div class="sidebar">
    <div class="sidebar-header">
        <h4>HMS</h4>
        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <p><?= session()->get('fullName') ?: 'User' ?></p>
        <small>
            <?= ucfirst(str_replace('_', ' ', session()->get('role') ?: 'Hospital Administrator')) ?> Dashboard
        </small>
    </div>

    <nav class="nav-menu">
        <ul>
            <li>
                <a href="<?= base_url('dashboard') ?>" <?= uri_string() === 'dashboard' ? 'class="active"' : '' ?>>
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="<?= base_url('patients') ?>" <?= uri_string() === 'patients' ? 'class="active"' : '' ?>>
                    <i class="fas fa-user-plus"></i>
                    Patient Registration & EHR
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-credit-card"></i>
                    Billing & Payment
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-chart-bar"></i>
                    Reports & Analytics
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-flask"></i>
                    Laboratory Management
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-pills"></i>
                    Pharmacy & Inventory
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-database"></i>
                    Database Status
                </a>
            </li>
            <?php if (in_array(session()->get('role'), ['admin', 'it_staff'])): ?>
            <li>
                <a href="<?= base_url('user-management') ?>">
                    <i class="fas fa-users-cog"></i>
                    User Management
                </a>
            </li>
            <?php endif; ?>
            <li>
                <a href="#">
                    <i class="fas fa-calendar-alt"></i>
                    Scheduling
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