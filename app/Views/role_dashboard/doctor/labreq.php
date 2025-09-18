<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'Lab Requests') ?> - HMS</title>
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