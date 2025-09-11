<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title) ?> - HMS</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #b9d3c9;
      overflow-x: hidden;
      background: #f2f2f2;
      min-height: 100vh;
      width: 100%;
    }

    .dashboard {
      display: flex;
      width: 100%;
      min-height: 100vh; 
      background: #b9d3c9;
      padding: 0;
    }

    /* Sidebar */
    .sidebar {
      width: 270px;
      background-color: #052719;
      color: white;
      padding: 15px;
      border-radius: 15px;
      height: calc(100vh - 30px);
      position: fixed;
      left: 15px;
      top: 15px;
      z-index: 1000;
      overflow-y: auto;
    }

    /* Main Content */
    .main {
      flex: 1;
      padding: 40px 40px 40px 340px;
      display: flex;
      flex-direction: column;
      gap: 20px;
      min-height: 100vh;
      width: 100%;
    }
    
        /* Schedule Layout Styles */
        .header {
            background: #81c798;
            height: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 10px rgba(0,0,0,.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            color: #052719;
            font-weight: bold;
            gap: 10px;
            margin-bottom: 20px;
        }

        .header-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .doctor-name {
            font-size: 14px;
            opacity: 0.9;
            font-weight: normal;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #052719;
            color: white;
        }

        .btn-primary:hover {
            background: #0f3d37;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .date-navigation {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 3px 6px rgba(0,0,0,.1);
            margin-bottom: 20px;
        }

        .current-week {
            font-weight: 600;
            color: #052719;
            font-size: 16px;
        }

        .schedule-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 6px rgba(0,0,0,.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 0;
        }

        .day-column {
            border-right: 1px solid #e6e6e6;
            min-height: 400px;
        }

        .day-column:last-child {
            border-right: none;
        }

        .day-header {
            background: #559680;
            color: white;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #e6e6e6;
        }

        .day-header h3 {
            margin: 0 0 5px 0;
            font-size: 16px;
        }

        .day-header .date {
            font-size: 12px;
            opacity: 0.9;
        }

        .appointments {
            padding: 10px;
            min-height: 350px;
        }

        .appointment-item {
            background: #f8f9fa;
            border: 1px solid #e6e6e6;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .appointment-item:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
        }

        .appointment-item .time {
            font-weight: 600;
            color: #052719;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .appointment-item .patient-info {
            margin-bottom: 8px;
        }

        .appointment-item .patient-info strong {
            display: block;
            color: #052719;
            font-size: 14px;
        }

        .appointment-item .patient-info span {
            color: #6c757d;
            font-size: 12px;
        }

        .appointment-item .patient-info small {
            color: #999;
            font-size: 10px;
            display: block;
            margin-top: 2px;
        }

        .status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }

        .status.confirmed {
            background: #d4edda;
            color: #155724;
        }

        .status.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status.urgent {
            background: #f8d7da;
            color: #721c24;
        }


    /* Responsive Design */
    @media (max-width: 1200px) {
      .main {
        padding: 20px 20px 20px 320px;
      }
    }

    @media (max-width: 992px) {
      .dashboard {
        padding: 15px;
        flex-direction: column;
      }
      
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        margin: 0 0 20px 0;
        border-radius: 10px;
      }

      .main {
        width: 100%;
        padding: 15px;
      }

      .schedule-grid {
        grid-template-columns: repeat(3, 1fr);
      }

      .header {
        flex-direction: column;
        height: auto;
        padding: 15px;
        gap: 15px;
      }

      .date-navigation {
        flex-direction: column;
        gap: 10px;
        text-align: center;
      }
    }

    @media (max-width: 768px) {
      .dashboard {
        padding: 10px;
      }

      .main {
        padding: 10px;
        gap: 15px;
      }

      .schedule-grid {
        grid-template-columns: 1fr;
      }
        
      .day-column {
        border-right: none;
        border-bottom: 1px solid #e6e6e6;
      }
        
      .day-column:last-child {
        border-bottom: none;
      }

      .header {
        padding: 12px;
      }

      .date-navigation {
        padding: 12px 15px;
      }

      .btn {
        padding: 6px 12px;
        font-size: 14px;
      }

      .appointment-item {
        padding: 8px;
        margin-bottom: 6px;
      }

      .appointment-item .time {
        font-size: 11px;
      }

      .appointment-item .patient-info strong {
        font-size: 13px;
      }

      .appointment-item .patient-info span {
        font-size: 11px;
      }
    }

    @media (max-width: 480px) {
      .dashboard {
        padding: 5px;
      }

      .main {
        padding: 5px;
      }

      .header {
        padding: 10px;
        font-size: 14px;
      }

      .date-navigation {
        padding: 10px;
      }

      .current-week {
        font-size: 14px;
      }

      .btn {
        padding: 8px 10px;
        font-size: 12px;
      }

      .day-header h3 {
        font-size: 14px;
      }

      .day-header .date {
        font-size: 11px;
      }

      .appointment-item {
        padding: 6px;
      }

      .appointment-item .time {
        font-size: 10px;
      }

      .appointment-item .patient-info strong {
        font-size: 12px;
      }

      .appointment-item .patient-info span {
        font-size: 10px;
      }

      .appointment-item .patient-info small {
        font-size: 9px;
      }

      .status {
        font-size: 9px;
        padding: 2px 6px;
      }
    }

    /* Sidebar specific responsive adjustments */
    @media (max-width: 992px) {
      .sidebar nav ul {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
      }

      .sidebar nav li {
        flex: 1;
        min-width: 150px;
        text-align: center;
      }

      .sidebar .profile {
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin-bottom: 20px;
      }

      .sidebar .avatar {
        width: 60px;
        height: 60px;
        margin-bottom: 0;
      }
    }

    @media (max-width: 480px) {
      .sidebar {
        padding: 10px;
      }

      .sidebar nav ul {
        flex-direction: column;
        gap: 5px;
      }

      .sidebar nav li {
        min-width: auto;
        padding: 8px;
        font-size: 13px;
      }

      .sidebar .profile {
        flex-direction: column;
        gap: 10px;
      }

      .sidebar .avatar {
        width: 50px;
        height: 50px;
      }
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <!-- Sidebar Navigation -->
    <?= $this->include('role_dashboard/doctor/_doctor_sidebar') ?>

    <!-- Main Content -->
    <main class="main">
      <header class="header">
        <i class="fas fa-calendar-check"></i> My Schedule
        <div class="header-info">
          <span class="doctor-name">Dr. <?= esc($user['name']) ?></span>
        </div>
      </header>

      <!-- Date Navigation -->
      <div class="date-navigation">
        <button class="btn btn-secondary" onclick="previousWeek()">
          <i class="fas fa-chevron-left"></i> Previous Week
        </button>
        <div class="current-week">
          <span id="weekDisplay">Week of January 15, 2024</span>
        </div>
        <button class="btn btn-secondary" onclick="nextWeek()">
          Next Week <i class="fas fa-chevron-right"></i>
        </button>
      </div>

      <!-- Schedule Grid -->
      <div class="schedule-container">
        <div class="schedule-grid">
          <!-- Monday -->
          <div class="day-column">
            <div class="day-header">
              <h3>Monday</h3>
              <span class="date">Jan 15</span>
            </div>
            <div class="appointments">
              <div class="appointment-item">
                <div class="time">09:00 AM</div>
                <div class="patient-info">
                  <strong>John Doe</strong>
                  <span>Regular Checkup</span>
                  <small>Room: 201-A | Duration: 30 min</small>
                </div>
                <div class="status confirmed">Confirmed</div>
              </div>
              <div class="appointment-item">
                <div class="time">10:30 AM</div>
                <div class="patient-info">
                  <strong>Jane Smith</strong>
                  <span>Follow-up</span>
                  <small>Room: 201-B | Duration: 45 min</small>
                </div>
                <div class="status pending">Pending</div>
              </div>
            </div>
          </div>

          <!-- Tuesday -->
          <div class="day-column">
            <div class="day-header">
              <h3>Tuesday</h3>
              <span class="date">Jan 16</span>
            </div>
            <div class="appointments">
              <div class="appointment-item">
                <div class="time">08:00 AM</div>
                <div class="patient-info">
                  <strong>Mike Johnson</strong>
                  <span>Consultation</span>
                  <small>Room: 202-A | Duration: 60 min</small>
                </div>
                <div class="status confirmed">Confirmed</div>
              </div>
            </div>
          </div>

          <!-- Wednesday -->
          <div class="day-column">
            <div class="day-header">
              <h3>Wednesday</h3>
              <span class="date">Jan 17</span>
            </div>
            <div class="appointments">
              <div class="appointment-item">
                <div class="time">11:00 AM</div>
                <div class="patient-info">
                  <strong>Sarah Wilson</strong>
                  <span>Annual Physical</span>
                  <small>Room: 203-A | Duration: 90 min</small>
                </div>
                <div class="status confirmed">Confirmed</div>
              </div>
            </div>
          </div>

          <!-- Thursday -->
          <div class="day-column">
            <div class="day-header">
              <h3>Thursday</h3>
              <span class="date">Jan 18</span>
            </div>
            <div class="appointments">
              <!-- No appointments -->
            </div>
          </div>

          <!-- Friday -->
          <div class="day-column">
            <div class="day-header">
              <h3>Friday</h3>
              <span class="date">Jan 19</span>
            </div>
            <div class="appointments">
              <div class="appointment-item">
                <div class="time">02:00 PM</div>
                <div class="patient-info">
                  <strong>Robert Brown</strong>
                  <span>Emergency Visit</span>
                  <small>Room: ER-1 | Duration: 45 min</small>
                </div>
                <div class="status urgent">Urgent</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      

  <script>
    // Week navigation functionality
    let currentWeek = new Date();
    
    function updateWeekDisplay() {
      const weekStart = new Date(currentWeek);
      weekStart.setDate(currentWeek.getDate() - currentWeek.getDay() + 1); // Monday
      
      const options = { month: 'long', day: 'numeric', year: 'numeric' };
      document.getElementById('weekDisplay').textContent = 
        `Week of ${weekStart.toLocaleDateString('en-US', options)}`;
    }
    
    function previousWeek() {
      currentWeek.setDate(currentWeek.getDate() - 7);
      updateWeekDisplay();
    }
    
    function nextWeek() {
      currentWeek.setDate(currentWeek.getDate() + 7);
      updateWeekDisplay();
    }
    
    
    // Initialize week display
    updateWeekDisplay();
  </script>
</body>
</html>
