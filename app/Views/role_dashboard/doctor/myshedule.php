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
            background: #f2f2f2;
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

        /* Schedule Filter Styles */
        .schedule-filter {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: center;
        }

        .filter-btn {
            padding: 12px 24px;
            border: 2px solid #559680;
            border-radius: 8px;
            background: white;
            color: #559680;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            background: #559680;
            color: white;
            transform: translateY(-2px);
        }

        .filter-btn.active {
            background: #559680;
            color: white;
        }

        .filter-btn i {
            font-size: 16px;
        }

        /* Status update styles */
        .status-actions {
            margin-top: 8px;
            display: flex;
            gap: 5px;
        }

        .status-btn {
            padding: 2px 6px;
            border: none;
            border-radius: 4px;
            font-size: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .status-btn.start {
            background: #007bff;
            color: white;
        }

        .status-btn.complete {
            background: #28a745;
            color: white;
        }

        .status-btn.cancel {
            background: #dc3545;
            color: white;
        }

        /* Table Styles */
        .schedule-table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 6px rgba(0,0,0,.1);
            overflow: hidden;
            margin-top: 20px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .schedule-table th {
            background: #559680;
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            border: none;
        }

        .schedule-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .schedule-table tr:hover {
            background-color: #f8f9fa;
        }

        .schedule-date {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .schedule-date .day {
            font-weight: bold;
            color: #559680;
            font-size: 12px;
        }

        .schedule-date .date {
            font-size: 14px;
            color: #333;
        }

        .schedule-time {
            display: flex;
            flex-direction: column;
        }

        .schedule-time .start-time {
            font-weight: bold;
            color: #333;
        }

        .schedule-time .end-time {
            font-size: 12px;
            color: #666;
        }

        .schedule-title strong {
            color: #333;
            font-size: 14px;
        }

        .schedule-title small {
            color: #666;
            font-size: 12px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .badge-type.badge-consultation {
            background: #e3f2fd;
            color: #1976d2;
        }

        .badge-type.badge-surgery {
            background: #fce4ec;
            color: #c2185b;
        }

        .badge-type.badge-rounds {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .badge-type.badge-emergency {
            background: #ffebee;
            color: #d32f2f;
        }

        .badge-type.badge-meeting {
            background: #e8f5e8;
            color: #388e3c;
        }

        .badge-status.badge-scheduled {
            background: #fff3cd;
            color: #856404;
        }

        .badge-status.badge-in_progress {
            background: #cce5ff;
            color: #0066cc;
        }

        .badge-status.badge-completed {
            background: #d4edda;
            color: #155724;
        }

        .badge-status.badge-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-sm:hover {
            opacity: 0.8;
            transform: translateY(-1px);
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


      <!-- Schedule Filter -->
      <div class="schedule-filter">
        <button class="filter-btn active" onclick="filterSchedules('today')" id="todayBtn">
          <i class="fas fa-calendar-day"></i> Today
        </button>
        <button class="filter-btn" onclick="filterSchedules('week')" id="weekBtn">
          <i class="fas fa-calendar-week"></i> This Week
        </button>
      </div>

      <!-- Schedule Table -->
      <div class="schedule-table-container">
        <div class="table-responsive">
          <table class="schedule-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Description</th>
                <th>Type</th>
                <th>Location</th>
                <th>Patient</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="scheduleTableBody">
              <!-- Today's schedules (default view) -->
              <?php if (!empty($todaySchedules)): ?>
                <?php foreach ($todaySchedules as $schedule): ?>
                  <tr class="schedule-row today-schedule">
                    <td>
                      <div class="schedule-date">
                        <span class="day"><?= date('D', strtotime($schedule['schedule_date'])) ?></span>
                        <span class="date"><?= date('M j', strtotime($schedule['schedule_date'])) ?></span>
                      </div>
                    </td>
                    <td>
                      <div class="schedule-time">
                        <span class="start-time"><?= date('g:i A', strtotime($schedule['start_time'])) ?></span>
                        <span class="end-time">- <?= date('g:i A', strtotime($schedule['end_time'])) ?></span>
                      </div>
                    </td>
                    <td>
                      <div class="schedule-title">
                        <strong><?= esc($schedule['description']) ?></strong>
                      </div>
                    </td>
                    <td>
                      <span class="badge badge-type badge-<?= $schedule['schedule_type'] ?>">
                        <?= ucfirst($schedule['schedule_type']) ?>
                      </span>
                    </td>
                    <td><?= esc($schedule['location']) ?></td>
                    <td>
                      <?php if (!empty($schedule['patient_first_name'])): ?>
                        <?= esc($schedule['patient_first_name'] . ' ' . $schedule['patient_last_name']) ?>
                      <?php else: ?>
                        <span class="text-muted">No patient assigned</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="action-buttons">
                        <button class="btn btn-sm btn-info" onclick="viewDetails(<?= $schedule['id'] ?>)">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
              
              <!-- Weekly schedules (hidden by default) -->
              <?php if (!empty($weeklySchedules)): ?>
                <?php foreach ($weeklySchedules as $schedule): ?>
                  <tr class="schedule-row week-schedule" style="display: none;">
                    <td>
                      <div class="schedule-date">
                        <span class="day"><?= date('D', strtotime($schedule['schedule_date'])) ?></span>
                        <span class="date"><?= date('M j', strtotime($schedule['schedule_date'])) ?></span>
                      </div>
                    </td>
                    <td>
                      <div class="schedule-time">
                        <span class="start-time"><?= date('g:i A', strtotime($schedule['start_time'])) ?></span>
                        <span class="end-time">- <?= date('g:i A', strtotime($schedule['end_time'])) ?></span>
                      </div>
                    </td>
                    <td>
                      <div class="schedule-title">
                        <strong><?= esc($schedule['description']) ?></strong>
                      </div>
                    </td>
                    <td>
                      <span class="badge badge-type badge-<?= $schedule['schedule_type'] ?>">
                        <?= ucfirst($schedule['schedule_type']) ?>
                      </span>
                    </td>
                    <td><?= esc($schedule['location']) ?></td>
                    <td>
                      <?php if (!empty($schedule['patient_first_name'])): ?>
                        <?= esc($schedule['patient_first_name'] . ' ' . $schedule['patient_last_name']) ?>
                      <?php else: ?>
                        <span class="text-muted">No patient assigned</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="action-buttons">
                        <button class="btn btn-sm btn-info" onclick="viewDetails(<?= $schedule['id'] ?>)">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
              
              <!-- Empty state -->
              <tr id="emptyState" style="display: none;">
                <td colspan="8" class="text-center text-muted py-4">
                  <i class="fas fa-calendar-times fa-2x mb-2"></i>
                  <p id="emptyMessage">No schedules found</p>
                </td>
              </tr>
            </tbody>
          </table>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    
    // Filter schedules function
    function filterSchedules(filter) {
        const todayBtn = document.getElementById('todayBtn');
        const weekBtn = document.getElementById('weekBtn');
        const todaySchedules = document.querySelectorAll('.today-schedule');
        const weekSchedules = document.querySelectorAll('.week-schedule');
        const emptyState = document.getElementById('emptyState');
        const emptyMessage = document.getElementById('emptyMessage');
        
        // Update button states
        todayBtn.classList.remove('active');
        weekBtn.classList.remove('active');
        
        if (filter === 'today') {
            todayBtn.classList.add('active');
            
            // Show today's schedules, hide weekly schedules
            todaySchedules.forEach(row => row.style.display = '');
            weekSchedules.forEach(row => row.style.display = 'none');
            
            // Check if there are today's schedules
            if (todaySchedules.length === 0) {
                emptyState.style.display = '';
                emptyMessage.textContent = 'No schedules for today';
            } else {
                emptyState.style.display = 'none';
            }
            
        } else if (filter === 'week') {
            weekBtn.classList.add('active');
            
            // Show weekly schedules, hide today's schedules
            todaySchedules.forEach(row => row.style.display = 'none');
            weekSchedules.forEach(row => row.style.display = '');
            
            // Check if there are weekly schedules
            if (weekSchedules.length === 0) {
                emptyState.style.display = '';
                emptyMessage.textContent = 'No schedules for this week';
            } else {
                emptyState.style.display = 'none';
            }
        }
    }
    
  </script>
</body>
</html>
