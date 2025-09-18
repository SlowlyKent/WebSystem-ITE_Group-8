<link rel="stylesheet" href="<?= base_url('assets/css/docnurse.css') ?>">
<aside class="sidebar">
  <h2>HMS</h2>
  <div class="profile">
    <div class="avatar">
        <i class="fas fa-user-md"></i>
    </div>
    <p><?= session()->get('fullName') ?: 'Doctor' ?></p>
    <small>Doctor Dashboard</small>
  </div>

  <nav>
    <ul>
        <li>
            <a href="<?= base_url('doctor/dashboard') ?>" 
               <?= uri_string() === 'doctor/dashboard' ? 'class="active"' : '' ?>>
               <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= base_url('doctor/patients') ?>" 
               <?= uri_string() === 'doctor/patients' ? 'class="active"' : '' ?>>
               <i class="fas fa-user-injured"></i> Patient Records
            </a>
        </li>
        <li>
            <a href="<?= base_url('doctor/my-schedule') ?>" 
               <?= uri_string() === 'doctor/my-schedule' ? 'class="active"' : '' ?>>
               <i class="fas fa-calendar-check"></i> My Schedule
            </a>
        </li>
        <li>
            <a href="<?= base_url('doctor/lab-results') ?>" 
               <?= uri_string() === 'doctor/lab-results' ? 'class="active"' : '' ?>>
               <i class="fas fa-flask"></i> Lab Results
            </a>
        </li>
        <li>
            <a href="<?= base_url('doctor/prescriptions') ?>" 
               <?= uri_string() === 'doctor/prescriptions' ? 'class="active"' : '' ?>>
               <i class="fas fa-pills"></i> Prescriptions
            </a>
        </li>
    </ul>
  </nav>

  <a href="<?= base_url('logout') ?>" class="btn logout">
    <i class="fas fa-sign-out-alt"></i> Log-out
  </a>
</aside>
