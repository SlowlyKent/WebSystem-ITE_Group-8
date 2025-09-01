<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Schedule</title>
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

    /* Header bar */
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
    tr:hover {
      background: #f1f1f1;
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
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <!-- Include reusable sidebar -->
    <?= $this->include('components/doctor_sidebar') ?>

    <!-- Main content -->
    <main class="main">
        <header class="header">
        <i class="fas fa-calendar"></i> My Schedule
      </header>

      <!-- Filters + New Lab Request -->
          <div class="filters-actions">
            <div class="filters">
              <button>Today</button>
              <button>This Week</button>
            </div>
          </div>

          <!-- Table -->
          <table>
            <thead>
              <tr>
                <th>Time</th>
                <th>Patient Name</th>
                <th>Reason for Visit</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr onclick="togglePanel('completedPanel')">
                <td>-----</td>
                <td>-----</td>
                <td>-----</td>
                <td>-----</td>
              </tr>
              <tr onclick="togglePanel('completedPanel')">
                <td>-----</td>
                <td>-----</td>
                <td>-----</td>
                <td>-----</td>
              </tr>
            </tbody>
          </table>
        </main>
      </div>
    </main>
  </div>
</body>
</html>
