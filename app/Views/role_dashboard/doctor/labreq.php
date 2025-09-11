<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'Lab Requests') ?> - HMS</title>
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

    .status.pending {
      background: #fff3cd;
      color: #856404;
    }

    .status.in-progress {
      background: #cce5ff;
      color: #004085;
    }

    .status.completed {
      background: #d4edda;
      color: #155724;
      cursor: pointer;
    }

    .status.completed:hover {
      background: #c3e6cb;
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

    /* Result Details Styles */
    .result-details {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 8px;
      margin-top: 10px;
    }

    .result-item {
      margin-bottom: 10px;
    }

    .result-item strong {
      color: #052719;
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
          <i class="fas fa-flask"></i> Lab Requests & Results
        </div>
        <div class="header-info">
          <span class="doctor-name">Dr. <?= esc(session()->get('fullName') ?? 'Doctor') ?></span>
        </div>
      </header>

      <!-- Filter Section -->
      <div class="filter-section">
        <div class="filter-buttons">
          <button class="filter-btn active" onclick="filterRequests('all')">All Requests</button>
          <button class="filter-btn" onclick="filterRequests('today')">Today</button>
          <button class="filter-btn" onclick="filterRequests('week')">This Week</button>
        </div>
        <button class="btn btn-primary" onclick="openNewRequestModal()">
          <i class="fas fa-plus"></i> New Lab Request
        </button>
      </div>

      <!-- Lab Requests Table -->
      <div class="table-section">
        <div class="table-header">
          <h3><i class="fas fa-list"></i> Lab Requests</h3>
          <span id="requestCount">Showing 5 requests</span>
        </div>
        <div class="table-container">
          <table id="labRequestsTable">
            <thead>
              <tr>
                <th>Patient ID</th>
                <th>Patient Name</th>
                <th>Test Requested</th>
                <th>Status</th>
                <th>Date</th>
                <th>Lab Staff</th>
              </tr>
            </thead>
            <tbody>
              <tr data-date="2024-01-20">
                <td>P001</td>
                <td>John Doe</td>
                <td>Complete Blood Count (CBC)</td>
                <td><span class="status completed" onclick="showResults('P001', 'John Doe', 'Complete Blood Count (CBC)', 'Dr. Sarah Johnson')">Completed</span></td>
                <td>2024-01-20</td>
                <td>Dr. Sarah Johnson</td>
              </tr>
              <tr data-date="2024-01-20">
                <td>P002</td>
                <td>Jane Smith</td>
                <td>Lipid Panel</td>
                <td><span class="status in-progress">In Progress</span></td>
                <td>2024-01-20</td>
                <td>Dr. Michael Chen</td>
              </tr>
              <tr data-date="2024-01-19">
                <td>P003</td>
                <td>Mike Johnson</td>
                <td>Thyroid Function Test</td>
                <td><span class="status completed" onclick="showResults('P003', 'Mike Johnson', 'Thyroid Function Test', 'Dr. Emily Davis')">Completed</span></td>
                <td>2024-01-19</td>
                <td>Dr. Emily Davis</td>
              </tr>
              <tr data-date="2024-01-18">
                <td>P004</td>
                <td>Sarah Wilson</td>
                <td>Urinalysis</td>
                <td><span class="status pending">Pending</span></td>
                <td>2024-01-18</td>
                <td>Dr. Robert Brown</td>
              </tr>
              <tr data-date="2024-01-17">
                <td>P005</td>
                <td>Robert Brown</td>
                <td>X-Ray Chest</td>
                <td><span class="status completed" onclick="showResults('P005', 'Robert Brown', 'X-Ray Chest', 'Dr. Lisa Anderson')">Completed</span></td>
                <td>2024-01-17</td>
                <td>Dr. Lisa Anderson</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <!-- New Lab Request Modal -->
  <div id="newRequestModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2><i class="fas fa-plus"></i> New Lab Request</h2>
        <span class="close" onclick="closeNewRequestModal()">&times;</span>
      </div>
      <form id="newRequestForm">
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
          <label for="testSelect">Lab Test:</label>
          <select id="testSelect" class="form-control" required>
            <option value="">Choose a test...</option>
            <option value="Complete Blood Count (CBC)">Complete Blood Count (CBC)</option>
            <option value="Basic Metabolic Panel">Basic Metabolic Panel</option>
            <option value="Lipid Panel">Lipid Panel</option>
            <option value="Liver Function Test">Liver Function Test</option>
            <option value="Thyroid Function Test">Thyroid Function Test</option>
            <option value="Urinalysis">Urinalysis</option>
            <option value="HbA1c">HbA1c (Diabetes)</option>
            <option value="X-Ray Chest">X-Ray Chest</option>
            <option value="ECG">ECG</option>
            <option value="Blood Culture">Blood Culture</option>
          </select>
        </div>

        <div class="form-group">
          <label for="labStaffSelect">Assign Lab Staff:</label>
          <select id="labStaffSelect" class="form-control" required>
            <option value="">Choose lab staff...</option>
            <option value="Dr. Sarah Johnson">Dr. Sarah Johnson</option>
            <option value="Dr. Michael Chen">Dr. Michael Chen</option>
            <option value="Dr. Emily Davis">Dr. Emily Davis</option>
            <option value="Dr. Robert Brown">Dr. Robert Brown</option>
            <option value="Dr. Lisa Anderson">Dr. Lisa Anderson</option>
            <option value="Tech. James Wilson">Tech. James Wilson</option>
            <option value="Tech. Maria Garcia">Tech. Maria Garcia</option>
          </select>
        </div>

        <div class="form-group">
          <label for="requestNotes">Notes:</label>
          <textarea id="requestNotes" class="form-control" placeholder="Additional notes or instructions..."></textarea>
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
          <button type="button" class="btn btn-secondary" onclick="closeNewRequestModal()">Cancel</button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-paper-plane"></i> Send Request
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Results Modal -->
  <div id="resultsModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2><i class="fas fa-clipboard-list"></i> Lab Results</h2>
        <span class="close" onclick="closeResultsModal()">&times;</span>
      </div>
      <div id="resultsContent">
        <!-- Results will be populated here -->
      </div>
    </div>
  </div>

  <script>
    // Filter functionality
    function filterRequests(filter) {
      const buttons = document.querySelectorAll('.filter-btn');
      buttons.forEach(btn => btn.classList.remove('active'));
      event.target.classList.add('active');

      const rows = document.querySelectorAll('#labRequestsTable tbody tr');
      const today = new Date().toISOString().split('T')[0];
      const weekAgo = new Date();
      weekAgo.setDate(weekAgo.getDate() - 7);
      const weekAgoStr = weekAgo.toISOString().split('T')[0];

      let visibleCount = 0;

      rows.forEach(row => {
        const rowDate = row.getAttribute('data-date');
        let show = false;

        switch(filter) {
          case 'all':
            show = true;
            break;
          case 'today':
            show = rowDate === today;
            break;
          case 'week':
            show = rowDate >= weekAgoStr;
            break;
        }

        row.style.display = show ? '' : 'none';
        if (show) visibleCount++;
      });

      document.getElementById('requestCount').textContent = `Showing ${visibleCount} requests`;
    }

    // Modal functions
    function openNewRequestModal() {
      document.getElementById('newRequestModal').style.display = 'block';
    }

    function closeNewRequestModal() {
      document.getElementById('newRequestModal').style.display = 'none';
      document.getElementById('newRequestForm').reset();
    }

    function closeResultsModal() {
      document.getElementById('resultsModal').style.display = 'none';
    }

    // Show results for completed tests
    function showResults(patientId, patientName, testType, labStaff) {
      const resultsContent = document.getElementById('resultsContent');
      
      let resultsHTML = `
        <div class="result-details">
          <div class="result-item">
            <strong>Patient:</strong> ${patientName} (${patientId})
          </div>
          <div class="result-item">
            <strong>Test:</strong> ${testType}
          </div>
          <div class="result-item">
            <strong>Lab Staff:</strong> ${labStaff}
          </div>
          <div class="result-item">
            <strong>Date Completed:</strong> ${new Date().toLocaleDateString()}
          </div>
          <div class="result-item">
            <strong>Status:</strong> Test completed successfully
          </div>
        </div>
      `;

      resultsContent.innerHTML = resultsHTML;
      document.getElementById('resultsModal').style.display = 'block';
    }

    // Form submission
    document.getElementById('newRequestForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const patientSelect = document.getElementById('patientSelect');
      const testSelect = document.getElementById('testSelect');
      const labStaffSelect = document.getElementById('labStaffSelect');
      const notes = document.getElementById('requestNotes').value;

      if (!patientSelect.value || !testSelect.value || !labStaffSelect.value) {
        alert('Please fill in all required fields.');
        return;
      }

      // In real implementation, this would submit to the server
      alert('Lab request submitted successfully!');
      closeNewRequestModal();
      
      // Add new row to table (simulation)
      const tbody = document.querySelector('#labRequestsTable tbody');
      const newRow = document.createElement('tr');
      newRow.setAttribute('data-date', new Date().toISOString().split('T')[0]);
      newRow.innerHTML = `
        <td>${patientSelect.value}</td>
        <td>${patientSelect.options[patientSelect.selectedIndex].text.split(' - ')[1]}</td>
        <td>${testSelect.value}</td>
        <td><span class="status pending">Pending</span></td>
        <td>${new Date().toISOString().split('T')[0]}</td>
        <td>${labStaffSelect.value}</td>
      `;
      tbody.insertBefore(newRow, tbody.firstChild);
      
      // Update count
      const currentCount = parseInt(document.getElementById('requestCount').textContent.match(/\d+/)[0]);
      document.getElementById('requestCount').textContent = `Showing ${currentCount + 1} requests`;
    });

    // Close modals when clicking outside
    window.onclick = function(event) {
      const newRequestModal = document.getElementById('newRequestModal');
      const resultsModal = document.getElementById('resultsModal');
      
      if (event.target === newRequestModal) {
        closeNewRequestModal();
      }
      if (event.target === resultsModal) {
        closeResultsModal();
      }
    }
  </script>
</body>
</html>