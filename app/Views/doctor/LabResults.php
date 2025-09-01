<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lab Request and Result</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
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

    .dashboard {
      display: flex;
      width: 100%;
      height: 100vh; 
      background: #b9d3c9;
      overflow: hidden;
      padding: 40px;
    }

    .header {
      background: #81c798ff;
      height: 50px;
      border-radius: 15px;
      box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
      display: flex;
      align-items: center;
      padding: 20px;
      color: #052719;
      font-weight: bold;
    }

    .main {
      flex: 1;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 20px;
      overflow-y: auto;  
      height: 100%;      
    }

    /* Search bar */
    .search-bar {
      display: flex;
      align-items: center;
      background: #fff;
      padding: 10px 12px;
      border-radius: 20px;
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
      gap: 10px;
      margin-top: 10px;
    }
    .search-bar input {
      border: none;
      outline: none;
      flex: 1;
    }

    /* Filters and actions */
    .filters-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .filters {
      display: flex;
      gap: 10px;
    }
    .filters button {
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 6px 12px;
      cursor: pointer;
    }
    .filters button:hover {
      background: #81c798;
      color: #fff;
    }
    .new-request {
      background: #81c798;
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
      cursor: pointer;
    }
    th {
      background-color: #559680; 
      color: #ffffff; 
      font-weight: 600;
    }

    /* Side panels */
    .side-panel {
      position: fixed;
      top: 0;
      right: -400px;
      width: 350px;
      height: 100%;
      background: #fff;
      box-shadow: -4px 0 6px rgba(0,0,0,0.2);
      padding: 20px;
      transition: right 0.3s ease;
      display: flex;
      flex-direction: column;
      gap: 15px;
      z-index: 1000;
    }
    .side-panel.active {
      right: 0;
    }
    .side-panel h2 {
      margin-bottom: 10px;
      color: #052719;
    }
    .side-panel input, .side-panel select, .side-panel textarea {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 8px;
      width: 100%;
    }
    .side-panel button {
      background: #81c798;
      color: #fff;
      border: none;
      padding: 10px;
      border-radius: 8px;
      cursor: pointer;
    }
    .side-panel button.secondary {
      background: #052719;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .dashboard {
        flex-direction: column;
      }
      .filters-actions {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
      }
      .new-request {
        align-self: flex-end;
      }
      .sidebar {
        width: 100%;
        flex-direction: row;
        justify-content: space-around;
        border-radius: 0;
        box-shadow: none;
      }
      .main {
        padding: 15px;}
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <?= $this->include('components/doctor_sidebar') ?>

    <!-- Main content -->
    <main class="main">
      <header class="header">
        <span><i class="fas fa-flask"></i> Lab Requests & Results</span>
      </header>

      <!-- Search bar -->
      <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search patient, test, or ID...">
      </div>

      <!-- Filters + New Lab Request -->
      <div class="filters-actions">
        <div class="filters">
          <button>Today</button>
          <button>This Week</button>
        </div>
        <button class="new-request" onclick="togglePanel('newLabPanel')">+ New Lab Request</button>
      </div>

      <!-- Table -->
      <table>
        <thead>
          <tr>
            <th>Patient Name</th>
            <th>Test Type</th>
            <th>Date Requested</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr onclick="togglePanel('completedPanel')">
            <td>Juan Dela Cruz</td>
            <td>Blood Test</td>
            <td>2025-08-31</td>
            <td>Pending</td>
          </tr>
          <tr onclick="togglePanel('completedPanel')">
            <td>Maria Santos</td>
            <td>X-Ray</td>
            <td>2025-08-30</td>
            <td>Completed</td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>

  <!-- New Lab Request Panel -->
  <div class="side-panel" id="newLabPanel">
    <h2>New Lab Request</h2>
    <select>
      <option>Select Patient</option>
      <option>Juan Dela Cruz</option>
      <option>Maria Santos</option>
    </select>
    <select>
      <option>Select Test Type</option>
      <option>Blood Test</option>
      <option>X-Ray</option>
      <option>Urine Test</option>
    </select>
    <textarea placeholder="Notes"></textarea>
    <input type="date">
    <button>Save Request</button>
  </div>

  <!-- Completed Lab Details Panel -->
  <div class="side-panel" id="completedPanel">
    <h2>Completed Lab Details</h2>
    <p><strong>Patient:</strong> Maria Santos</p>
    <p><strong>Test Type:</strong> X-Ray</p>
    <p><strong>Date Requested:</strong> 2025-08-30</p>
    <p><strong>Status:</strong> Completed</p>
    <p><strong>Results:</strong> No abnormalities detected.</p>
    <button>Close</button>
  </div>

  <script>
    function togglePanel(panelId) {
      // close other panels
      document.querySelectorAll('.side-panel').forEach(p => p.classList.remove('active'));
      // open selected panel
      document.getElementById(panelId).classList.add('active');
    }

    // Close if clicking outside
    document.addEventListener('click', function(e) {
      const panels = document.querySelectorAll('.side-panel');
      const buttons = document.querySelectorAll('.new-request, tbody tr');
      let clickedInsidePanel = false;

      panels.forEach(panel => {
        if (panel.contains(e.target)) clickedInsidePanel = true;
      });
      buttons.forEach(btn => {
        if (btn.contains(e.target)) clickedInsidePanel = true;
      });

      if (!clickedInsidePanel) {
        panels.forEach(panel => panel.classList.remove('active'));
      }
    });
  </script>
</body>
</html>
