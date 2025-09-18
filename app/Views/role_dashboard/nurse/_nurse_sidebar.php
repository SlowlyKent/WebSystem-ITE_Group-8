<link rel="stylesheet" href="<?= base_url('assets/css/docnurse.css') ?>">
<aside class="sidebar">
  <h2>HMS</h2>
  <div class="profile">
    <div class="avatar">
        <i class="fas fa-user-nurse"></i>
    </div>
    <p><?= session()->get('fullName') ?: 'Nurse' ?></p>
    <small>Nurse Dashboard</small>
  </div>

  <nav>
    <ul>
        <li>
            <a href="<?= base_url('nurse/dashboard') ?>" 
               <?= uri_string() === 'nurse/dashboard' ? 'class="active"' : '' ?>>
               <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= base_url('nurse/patient-assignments') ?>" 
               <?= uri_string() === 'nurse/patient-assignments' ? 'class="active"' : '' ?>>
               <i class="fas fa-user-injured"></i> Patient Assignments
            </a>
        </li>
        <li>
            <a href="<?= base_url('nurse/vital-signs') ?>" 
               <?= uri_string() === 'nurse/vital-signs' ? 'class="active"' : '' ?>>
               <i class="fas fa-heartbeat"></i> Vital Signs
            </a>
        </li>
        <li>
            <a href="<?= base_url('nurse/medication-admin') ?>" 
               <?= uri_string() === 'nurse/medication-admin' ? 'class="active"' : '' ?>>
               <i class="fas fa-pills"></i> Medication Administration
            </a>
        </li>
        <li>
            <a href="<?= base_url('nurse/nursing-notes') ?>" 
               <?= uri_string() === 'nurse/nursing-notes' ? 'class="active"' : '' ?>>
               <i class="fas fa-clipboard-list"></i> Nursing Notes
            </a>
        </li>
        <li>
            <a href="<?= base_url('nurse/shift-handover') ?>" 
               <?= uri_string() === 'nurse/shift-handover' ? 'class="active"' : '' ?>>
               <i class="fas fa-exchange-alt"></i> Shift Handover
            </a>
        </li>
    </ul>
  </nav>

  <a href="<?= base_url('logout') ?>" class="btn logout">
    <i class="fas fa-sign-out-alt"></i> Log-out
  </a>
</aside>
