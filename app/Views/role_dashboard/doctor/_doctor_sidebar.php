<style>
/* Sidebar */
.sidebar {
    position: fixed;
    left: 15px;
    top: 15px;
    width: 270px;
    height: calc(100vh - 30px);
    background: #052719;
    padding: 15px;
    border-radius: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0px 6px 10px 4px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    overflow-y: auto;
    padding-bottom: 15px;
}

/* Responsive sidebar */
@media (max-width: 992px) {
    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        margin: 0 0 20px 0;
        border-radius: 10px;
    }
}

.sidebar h2 {
    align-items: center;
    font-size: 20px;
    display: flex;
    justify-content: center;
    color: #fff;
    padding-top: 20px;
}

.profile {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
}

.avatar {
    width: 80px;
    height: 80px;
    border: 3px solid #fff;
    border-radius: 50%;
    margin-bottom: 10px;
    background: #385851;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    margin-top: 5px;
}

.btn.primary {
    background: #456b3d;
    color: #fff;
    font-size: 14px;
}

.btn.logout {
    margin-top: 20px;
    padding: 10px;
    border: none;
    background: #385851;
    color: #fff;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn.logout:hover {
    background: #598b81;
}

.sidebar nav ul {
    list-style: none;
    margin: 20px 0;
    padding: 0;
}

.sidebar nav li {
    padding: 12px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 6px;
    color: #fff;
}

.sidebar nav li:hover {
    background: #0f6b45;
}

.sidebar nav li i {
    margin-right: 8px;
    color: #fff;
    transition: color 0.3s;
}

.sidebar nav li a {
    padding-left: 8px;
    text-decoration: none;
    color: #fff;
    font-weight: bold;
    transition: color 0.3s;
    display: flex;
    align-items: center;
}

.sidebar nav li:hover i,
.sidebar nav li:hover a {
    color: #00ff95;
}
</style>

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
