<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Doctor Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background: #f2f2f2;
      min-height: 100vh;
      width: 100%;
    }

    /* Main container */
    .dashboard {
      display: flex;
      width: 100%;
      height: 100vh; 
      background: #b9d3c9;
      overflow: hidden;
      padding: 40px;
    }

    /* Main content */
    .main {
      flex: 1;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 20px;
      overflow-y: auto;  
      height: 100%;      
    }

    /* Header bar */
    .header {
      background: #81c798ff;
      height: 50px;
      border-radius: 15px;
      box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
    }

    /* Stats cards */
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

    /* Schedule */
    .schedule {
      background: #fff;
      flex: 1;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .schedule h3 {
      margin-bottom: 10px;
      font-size: 16px;
    }

    /* Bottom panels */
    .bottom-panels {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .panel {
      background: #fff;
      flex: 1;
      min-width: 200px;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .panel h3 {
      font-size: 16px;
      margin-bottom: 10px;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .dashboard {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        flex-direction: row;
        justify-content: space-around;
        border-radius: 0;
        box-shadow: none;
      }
      .main {
        padding: 15px;
      }
      .stats, .bottom-panels {
        flex-direction: column;
        gap: 20px;
        margin-bottom: 40px;
      }
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <!-- Include reusable sidebar -->
    <?= $this->include('components/doctor_sidebar') ?>

    <!-- Main content -->
    <main class="main">
      <header class="header"></header>

      <section class="stats">
        <div class="card">
          <i class="fa-solid fa-calendar-check"></i>
          <span>0</span>
          <p>Appointments</p>
        </div>
        <div class="card">
          <i class="fa-solid fa-vials"></i>
          <span>0</span>
          <p>Pending Lab Results</p>
        </div>
        <div class="card">
          <i class="fas fa-pills"></i>
          <span>0</span>
          <p>Prescribed Medicines</p>
        </div>
      </section>

      <section class="schedule">
        <h3>Today's Schedule</h3>
      </section>

      <section class="bottom-panels">
        <div class="panel">
          <h3>Patient Queue</h3>
        </div>
        <div class="panel">
          <h3>Lab Requests & Results</h3>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
