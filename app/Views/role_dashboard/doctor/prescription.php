<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'Prescriptions') ?> - HMS</title>
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

    .header {
      background: #81c798;
      height: 60px;
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
      text-decoration: none;
    }

    .btn-primary {
      background: #052719;
      color: white;
    }

    .btn-primary:hover {
      background: #0f3d37;
      transform: translateY(-2px);
    }

    .btn-success {
      background: #28a745;
      color: white;
    }

    .btn-success:hover {
      background: #218838;
    }

    .btn-secondary {
      background: #6c757d;
      color: white;
    }

    .btn-secondary:hover {
      background: #5a6268;
    }

    /* Filter Section */
    .filter-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 15px;
    }

    .filter-buttons {
      display: flex;
      gap: 10px;
    }

    .filter-btn {
      padding: 8px 16px;
      border: 2px solid #052719;
      background: white;
      color: #052719;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .filter-btn.active,
    .filter-btn:hover {
      background: #052719;
      color: white;
    }

    /* Table Section */
    .table-section {
      background: white;
      border-radius: 10px;
      box-shadow: 0 3px 6px rgba(0,0,0,.1);
      overflow: hidden;
      margin-bottom: 20px;
    }

    .table-header {
      background: #559680;
      color: white;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .table-container {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #e6e6e6;
    }

    th {
      background: #f8f9fa;
      font-weight: 600;
      color: #052719;
    }

    tr:hover {
      background: #f8f9fa;
    }

    .status {
      padding: 4px 12px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      display: inline-block;
    }

    .status.active {
      background: #d4edda;
      color: #155724;
    }

    .status.completed {
      background: #cce5ff;
      color: #004085;
    }

    .status.expired {
      background: #f8d7da;
      color: #721c24;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 2000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
      background-color: white;
      margin: 5% auto;
      padding: 20px;
      border-radius: 10px;
      width: 90%;
      max-width: 600px;
      max-height: 80vh;
      overflow-y: auto;
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid #e6e6e6;
    }

    .close {
      color: #aaa;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover {
      color: #000;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
      color: #052719;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 14px;
    }

    .form-control:focus {
      outline: none;
      border-color: #052719;
      box-shadow: 0 0 0 2px rgba(5, 39, 25, 0.1);
    }

    textarea.form-control {
      resize: vertical;
      min-height: 80px;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
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

      .filter-section {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
      }

      .filter-buttons {
        justify-content: center;
        flex-wrap: wrap;
      }

      .header {
        flex-direction: column;
        height: auto;
        padding: 15px;
        gap: 15px;
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

      .header {
        padding: 12px;
      }

      .table-container {
        font-size: 14px;
      }

      th, td {
        padding: 8px 6px;
        font-size: 13px;
      }

      .form-row {
        grid-template-columns: 1fr;
      }

      .modal-content {
        width: 95%;
        margin: 2% auto;
        padding: 15px;
      }

      .btn {
        padding: 6px 12px;
        font-size: 14px;
      }

      .filter-btn {
        padding: 6px 12px;
        font-size: 14px;
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

      .table-header {
        padding: 10px 12px;
        flex-direction: column;
        gap: 10px;
        text-align: center;
      }

      th, td {
        padding: 6px 4px;
        font-size: 12px;
      }

      .status {
        font-size: 10px;
        padding: 2px 6px;
      }

      .filter-buttons {
        flex-direction: column;
        gap: 8px;
      }

      .filter-btn {
        padding: 8px 12px;
        text-align: center;
      }

      .modal-content {
        width: 98%;
        margin: 1% auto;
        padding: 12px;
      }

      .form-control {
        padding: 8px;
        font-size: 14px;
      }

      .btn {
        padding: 8px 12px;
        font-size: 13px;
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
        <div class="header-info">
          <i class="fas fa-pills"></i> Prescriptions
        </div>
        <div class="header-info">
          <span class="doctor-name">Dr. <?= esc(session()->get('fullName') ?? 'Doctor') ?></span>
        </div>
      </header>

      <!-- Filter Section -->
      <div class="filter-section">
        <div class="filter-buttons">
          <button class="filter-btn active" onclick="filterPrescriptions('all')">All Prescriptions</button>
          <button class="filter-btn" onclick="filterPrescriptions('active')">Active</button>
          <button class="filter-btn" onclick="filterPrescriptions('completed')">Completed</button>
        </div>
        <button class="btn btn-primary" onclick="openNewPrescriptionModal()">
          <i class="fas fa-plus"></i> New Prescription
        </button>
      </div>

      <!-- Prescriptions Table -->
      <div class="table-section">
        <div class="table-header">
          <h3><i class="fas fa-list"></i> Patient Prescriptions</h3>
          <span id="prescriptionCount">Showing 5 prescriptions</span>
        </div>
        <div class="table-container">
          <table id="prescriptionsTable">
            <thead>
              <tr>
                <th>Patient ID</th>
                <th>Patient Name</th>
                <th>Medication</th>
                <th>Dosage</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Date Prescribed</th>
              </tr>
            </thead>
            <tbody>
              <tr data-status="active">
                <td>P001</td>
                <td>John Doe</td>
                <td>Amoxicillin</td>
                <td>500mg, 3x daily</td>
                <td>7 days</td>
                <td><span class="status active">Active</span></td>
                <td>2024-01-20</td>
              </tr>
              <tr data-status="active">
                <td>P002</td>
                <td>Jane Smith</td>
                <td>Lisinopril</td>
                <td>10mg, once daily</td>
                <td>30 days</td>
                <td><span class="status active">Active</span></td>
                <td>2024-01-19</td>
              </tr>
              <tr data-status="completed">
                <td>P003</td>
                <td>Mike Johnson</td>
                <td>Ibuprofen</td>
                <td>400mg, as needed</td>
                <td>14 days</td>
                <td><span class="status completed">Completed</span></td>
                <td>2024-01-15</td>
              </tr>
              <tr data-status="active">
                <td>P004</td>
                <td>Sarah Wilson</td>
                <td>Metformin</td>
                <td>500mg, twice daily</td>
                <td>90 days</td>
                <td><span class="status active">Active</span></td>
                <td>2024-01-18</td>
              </tr>
              <tr data-status="expired">
                <td>P005</td>
                <td>Robert Brown</td>
                <td>Prednisone</td>
                <td>20mg, once daily</td>
                <td>5 days</td>
                <td><span class="status expired">Expired</span></td>
                <td>2024-01-10</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <!-- New Prescription Modal -->
  <div id="newPrescriptionModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2><i class="fas fa-plus"></i> New Prescription</h2>
        <span class="close" onclick="closeNewPrescriptionModal()">&times;</span>
      </div>
      <form id="newPrescriptionForm">
        <div class="form-group">
          <label for="patientSelect">Select Patient:</label>
          <select id="patientSelect" class="form-control" required>
            <option value="">Choose a patient...</option>
            <option value="P001">P001 - John Doe</option>
            <option value="P002">P002 - Jane Smith</option>
            <option value="P003">P003 - Mike Johnson</option>
            <option value="P004">P004 - Sarah Wilson</option>
            <option value="P005">P005 - Robert Brown</option>
            <option value="P006">P006 - Mary Davis</option>
            <option value="P007">P007 - David Miller</option>
          </select>
        </div>

        <div class="form-group">
          <label for="medicationSelect">Medication:</label>
          <select id="medicationSelect" class="form-control" required>
            <option value="">Choose medication...</option>
            <option value="Amoxicillin">Amoxicillin</option>
            <option value="Lisinopril">Lisinopril</option>
            <option value="Metformin">Metformin</option>
            <option value="Ibuprofen">Ibuprofen</option>
            <option value="Prednisone">Prednisone</option>
            <option value="Atorvastatin">Atorvastatin</option>
            <option value="Omeprazole">Omeprazole</option>
            <option value="Amlodipine">Amlodipine</option>
            <option value="Levothyroxine">Levothyroxine</option>
            <option value="Hydrochlorothiazide">Hydrochlorothiazide</option>
          </select>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="dosage">Dosage:</label>
            <input type="text" id="dosage" class="form-control" placeholder="e.g., 500mg" required>
          </div>
          <div class="form-group">
            <label for="frequency">Frequency:</label>
            <select id="frequency" class="form-control" required>
              <option value="">Select frequency...</option>
              <option value="Once daily">Once daily</option>
              <option value="Twice daily">Twice daily</option>
              <option value="3x daily">3 times daily</option>
              <option value="4x daily">4 times daily</option>
              <option value="As needed">As needed</option>
              <option value="Every 4 hours">Every 4 hours</option>
              <option value="Every 6 hours">Every 6 hours</option>
              <option value="Every 8 hours">Every 8 hours</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="duration">Duration:</label>
            <input type="text" id="duration" class="form-control" placeholder="e.g., 7 days, 30 days" required>
          </div>
          <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" class="form-control" placeholder="e.g., 30" required>
          </div>
        </div>

        <div class="form-group">
          <label for="instructions">Instructions:</label>
          <textarea id="instructions" class="form-control" placeholder="Additional instructions for the patient..."></textarea>
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
          <button type="button" class="btn btn-secondary" onclick="closeNewPrescriptionModal()">Cancel</button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-prescription-bottle"></i> Create Prescription
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Filter functionality
    function filterPrescriptions(filter) {
      const buttons = document.querySelectorAll('.filter-btn');
      buttons.forEach(btn => btn.classList.remove('active'));
      event.target.classList.add('active');

      const rows = document.querySelectorAll('#prescriptionsTable tbody tr');
      let visibleCount = 0;

      rows.forEach(row => {
        const status = row.getAttribute('data-status');
        let show = false;

        switch(filter) {
          case 'all':
            show = true;
            break;
          case 'active':
            show = status === 'active';
            break;
          case 'completed':
            show = status === 'completed';
            break;
        }

        row.style.display = show ? '' : 'none';
        if (show) visibleCount++;
      });

      document.getElementById('prescriptionCount').textContent = `Showing ${visibleCount} prescriptions`;
    }

    // Modal functions
    function openNewPrescriptionModal() {
      document.getElementById('newPrescriptionModal').style.display = 'block';
    }

    function closeNewPrescriptionModal() {
      document.getElementById('newPrescriptionModal').style.display = 'none';
      document.getElementById('newPrescriptionForm').reset();
    }

    // Form submission
    document.getElementById('newPrescriptionForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const patientSelect = document.getElementById('patientSelect');
      const medicationSelect = document.getElementById('medicationSelect');
      const dosage = document.getElementById('dosage').value;
      const frequency = document.getElementById('frequency').value;
      const duration = document.getElementById('duration').value;
      const quantity = document.getElementById('quantity').value;

      if (!patientSelect.value || !medicationSelect.value || !dosage || !frequency || !duration || !quantity) {
        alert('Please fill in all required fields.');
        return;
      }

      // In real implementation, this would submit to the server
      alert('Prescription created successfully!');
      closeNewPrescriptionModal();
      
      // Add new row to table (simulation)
      const tbody = document.querySelector('#prescriptionsTable tbody');
      const newRow = document.createElement('tr');
      newRow.setAttribute('data-status', 'active');
      newRow.innerHTML = `
        <td>${patientSelect.value}</td>
        <td>${patientSelect.options[patientSelect.selectedIndex].text.split(' - ')[1]}</td>
        <td>${medicationSelect.value}</td>
        <td>${dosage}, ${frequency}</td>
        <td>${duration}</td>
        <td><span class="status active">Active</span></td>
        <td>${new Date().toISOString().split('T')[0]}</td>
      `;
      tbody.insertBefore(newRow, tbody.firstChild);
      
      // Update count
      const currentCount = parseInt(document.getElementById('prescriptionCount').textContent.match(/\d+/)[0]);
      document.getElementById('prescriptionCount').textContent = `Showing ${currentCount + 1} prescriptions`;
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
      const modal = document.getElementById('newPrescriptionModal');
      if (event.target === modal) {
        closeNewPrescriptionModal();
      }
    }
  </script>
</body>
</html>