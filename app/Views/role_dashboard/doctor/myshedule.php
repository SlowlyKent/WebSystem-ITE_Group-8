<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title) ?> - HMS</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/docnurse.css') ?>">
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
