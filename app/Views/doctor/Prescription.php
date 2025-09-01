<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Prescriptions - Doctor Dashboard</title>
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
      display: flex;
      align-items: center;
      padding: 20px;
      color: #052719;
      font-weight: bold;
    }

    /* Content sections */
    .content-section {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .content-section h3 {
      margin-bottom: 15px;
      color: #052719;
      font-size: 18px;
    }

    /* Form styles */
    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #052719;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 14px;
    }

    .form-group textarea {
      height: 100px;
      resize: vertical;
    }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background: #456b3dff;
      color: #fff;
    }

    .btn-primary:hover {
      background: #0f6b45;
      transform: translateY(-2px);
    }

    .btn-secondary {
      background: #6c757d;
      color: #fff;
      margin-left: 10px;
    }

    .btn-secondary:hover {
      background: #5a6268;
      transform: translateY(-2px);
    }

    /* Table styles */
    .table-container {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background: #f8f9fa;
      font-weight: bold;
      color: #052719;
    }

    tr:hover {
      background: #f5f5f5;
    }

    .action-buttons {
      display: flex;
      gap: 5px;
    }

    .btn-edit {
      background: #ffc107;
      color: #000;
      padding: 5px 10px;
      font-size: 12px;
    }

    .btn-delete {
      background: #dc3545;
      color: #fff;
      padding: 5px 10px;
      font-size: 12px;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .dashboard {
        flex-direction: column;
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
        <i class="fas fa-pills"></i> Prescription Management
      </header>

      <!-- New Prescription Form -->
      <section class="content-section">
        <h3><i class="fas fa-plus-circle"></i> New Prescription</h3>
        <form>
          <div class="form-group">
            <label for="patient">Patient Name</label>
            <select id="patient" name="patient" required>
              <option value="">Select Patient</option>
              <option value="1">John Doe</option>
              <option value="2">Jane Smith</option>
              <option value="3">Mike Johnson</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="medication">Medication</label>
            <input type="text" id="medication" name="medication" placeholder="Enter medication name" required>
          </div>

          <div class="form-group">
            <label for="frequency">Frequency</label>
            <select id="frequency" name="frequency" required>
              <option value="">Select frequency</option>
              <option value="once_daily">Once daily</option>
              <option value="twice_daily">Twice daily</option>
              <option value="three_times">Three times daily</option>
              <option value="as_needed">As needed</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="duration">Duration</label>
            <input type="text" id="duration" name="duration" placeholder="e.g., 7 days" required>
          </div>
          
          <div class="form-group">
            <label for="instructions">Special Instructions</label>
            <textarea id="instructions" name="instructions" placeholder="Enter any special instructions for the patient"></textarea>
          </div>
          
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Prescription
          </button>
          <button type="reset" class="btn btn-secondary">
            <i class="fas fa-undo"></i> Reset
          </button>
        </form>
      </section>

      <!-- Prescriptions List -->
      <section class="content-section">
        <h3><i class="fas fa-list"></i> Recent Prescriptions</h3>
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Date</th>
                <th>Patient</th>
                <th>Medication</th>
                <th>Frequency</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>2024-01-15</td>
                <td>John Doe</td>
                <td>Amoxicillin</td>
                <td>Three times daily</td>
                <td><span style="color: #28a745;">Active</span></td>
                <td class="action-buttons">
                  <button class="btn btn-edit"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td>2024-01-14</td>
                <td>Jane Smith</td>
                <td>Ibuprofen</td>
                <td>As needed</td>
                <td><span style="color: #28a745;">Active</span></td>
                <td class="action-buttons">
                  <button class="btn btn-edit"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
              <tr>
                <td>2024-01-13</td>
                <td>Mike Johnson</td>
                <td>Omeprazole</td>
                <td>Once daily</td>
                <td><span style="color: #6c757d;">Completed</span></td>
                <td class="action-buttons">
                  <button class="btn btn-edit"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>
</body>
</html>

