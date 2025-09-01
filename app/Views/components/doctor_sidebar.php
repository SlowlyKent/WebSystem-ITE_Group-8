<!-- Doctor Sidebar Component -->
<aside class="sidebar">
  <h2>HMS</h2>
  <div class="profile">
    <div class="avatar"></div>
    <button class="btn primary">Doctor Dashboard</button>
  </div>
  <nav>
    <ul>
        <li><i class="fas fa-tachometer-alt"></i><a href="../../doctor">Dashboard</a></li>
        <li><i class="fas fa-user"></i><a href="../../doctor/patient-ehr">Patient EHR</a></li>
        <li><i class="fas fa-calendar-check"></i><a href="../../doctor/my-schedule">My Schedule</a></li>
        <li><i class="fas fa-flask"></i><a href="../../doctor/lab-results">Lab Requests & Results</a></li>
        <li><i class="fas fa-pills"></i><a href="../../doctor/prescriptions">Prescriptions</a></li>
    </ul>
  </nav>
  <a href="../../logout" class="btn logout">Log-out</a>
</aside>
<style>
  /* Sidebar */
    .sidebar {
        width: 270px;
        background: #052719;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-radius: 27px;
        box-shadow: 0px 6px 10px 4px rgba(0, 0, 0, 0.15), 0px 2px 3px rgba(0, 0, 0, 0.3);
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
      border: 3px solid #ffffffff;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .btn {
      padding: 8px 16px;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      margin-top: 5px;
    }

    .btn.primary {
      background: #456b3dff;
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
    }

    .btn.logout:hover {
        background: #598b81;
    }

    .sidebar nav ul {
    list-style: none;
    margin: 20px 0;
    }

    .sidebar nav li {
    padding: 15px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 6px;
    color: #fff;
    }

    .sidebar nav li:hover {
    background: #0f6b45;
    }

    li {
    list-style: none;
    margin: 8px 0;
    display: flex;
    align-items: center;
    }

    li i {
    margin-right: 8px;
    color: #ffffffff; 
    transition: color 0.3s;
    }

    li a {
    padding-left: 8px;
    text-decoration: none;  
    color: #ffffffff;            
    font-weight: bold;
    transition: color 0.3s;
    }

    li:hover i,
    li:hover a {
    color: green; 
    }

</style>
