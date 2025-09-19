<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'Prescriptions') ?> - HMS</title>
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
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="prescriptionsTableBody">
              <!-- Dynamic prescriptions will be loaded here -->
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
            <option value="">Loading patients...</option>
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

  <!-- Edit Prescription Modal -->
  <div id="editPrescriptionModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2><i class="fas fa-edit"></i> Edit Prescription</h2>
        <span class="close" onclick="closeEditPrescriptionModal()">&times;</span>
      </div>
      <form id="editPrescriptionForm">
        <input type="hidden" id="editPrescriptionId">
        
        <div class="form-group">
          <label for="editPatientSelect">Select Patient:</label>
          <select id="editPatientSelect" class="form-control" required>
            <option value="">Loading patients...</option>
          </select>
        </div>

        <div class="form-group">
          <label for="editMedicationSelect">Medication:</label>
          <select id="editMedicationSelect" class="form-control" required>
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
            <label for="editDosage">Dosage:</label>
            <input type="text" id="editDosage" class="form-control" placeholder="e.g., 500mg" required>
          </div>
          <div class="form-group">
            <label for="editFrequency">Frequency:</label>
            <select id="editFrequency" class="form-control" required>
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
            <label for="editDuration">Duration:</label>
            <input type="text" id="editDuration" class="form-control" placeholder="e.g., 7 days, 30 days" required>
          </div>
          <div class="form-group">
            <label for="editStatus">Status:</label>
            <select id="editStatus" class="form-control" required>
              <option value="active">Active</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="editInstructions">Instructions:</label>
          <textarea id="editInstructions" class="form-control" placeholder="Additional instructions for the patient..."></textarea>
        </div>

        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
          <button type="button" class="btn btn-secondary" onclick="closeEditPrescriptionModal()">Cancel</button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Update Prescription
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Load prescriptions from database on page load
    document.addEventListener('DOMContentLoaded', function() {
      loadPrescriptions();
    });

    async function loadPrescriptions() {
      try {
        const response = await fetch('<?= base_url('api/prescriptions') ?>');
        const result = await response.json();
        
        if (result.success) {
          displayPrescriptions(result.data);
        } else {
          console.error('Failed to load prescriptions:', result.message);
          // Show empty state or error message
          document.getElementById('prescriptionsTableBody').innerHTML = '<tr><td colspan="8" class="text-center">No prescriptions found</td></tr>';
        }
      } catch (error) {
        console.error('Error loading prescriptions:', error);
        document.getElementById('prescriptionsTableBody').innerHTML = '<tr><td colspan="8" class="text-center">Error loading prescriptions</td></tr>';
      }
    }

    function displayPrescriptions(prescriptions) {
      const tbody = document.getElementById('prescriptionsTableBody');
      
      // Clear existing rows
      tbody.innerHTML = '';
      
      if (prescriptions.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">No prescriptions found</td></tr>';
        document.getElementById('prescriptionCount').textContent = 'Showing 0 prescriptions';
        return;
      }
      
      // Display all prescriptions
      prescriptions.forEach(prescription => {
        const row = document.createElement('tr');
        row.setAttribute('data-status', prescription.status);
        row.setAttribute('data-id', prescription.id);
        
        // Format the prescribed date
        const prescribedDate = new Date(prescription.prescribed_date).toLocaleDateString();
        
        row.innerHTML = `
          <td>P${prescription.patient_id.toString().padStart(3, '0')}</td>
          <td>${prescription.patient_name}</td>
          <td>${prescription.medication_name}</td>
          <td>${prescription.dosage}${prescription.frequency ? ', ' + prescription.frequency : ''}</td>
          <td>${prescription.duration || 'N/A'}</td>
          <td>
            <span class="status ${prescription.status}" onclick="updateStatus(${prescription.id}, '${prescription.status}')">
              ${prescription.status.charAt(0).toUpperCase() + prescription.status.slice(1)}
            </span>
          </td>
          <td>${prescribedDate}</td>
          <td>
            <button class="btn btn-sm btn-primary" onclick="editPrescription(${prescription.id})" style="margin-right: 5px; padding: 4px 8px; font-size: 12px;">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm" onclick="deletePrescription(${prescription.id})" style="background: #dc3545; color: white; padding: 4px 8px; font-size: 12px;">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        `;
        tbody.appendChild(row);
      });
      
      // Update count
      document.getElementById('prescriptionCount').textContent = `Showing ${prescriptions.length} prescriptions`;
    }

    // Function to update prescription status
    async function updateStatus(prescriptionId, currentStatus) {
      const newStatus = currentStatus === 'active' ? 'completed' : 'active';
      
      try {
        const response = await fetch(`<?= base_url('api/prescriptions/update-status/') ?>${prescriptionId}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({ status: newStatus })
        });
        
        const result = await response.json();
        
        if (result.success) {
          // Reload prescriptions to reflect changes
          loadPrescriptions();
        } else {
          alert('Error updating status: ' + result.message);
        }
      } catch (error) {
        console.error('Error updating status:', error);
        alert('Network error. Please try again.');
      }
    }

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
    async function openNewPrescriptionModal() {
      document.getElementById('newPrescriptionModal').style.display = 'block';
      await loadAssignedPatients();
    }

    // Load patients assigned to current doctor
    async function loadAssignedPatients() {
      try {
        const response = await fetch('<?= base_url('api/prescriptions/assigned-patients') ?>');
        const result = await response.json();
        
        const patientSelect = document.getElementById('patientSelect');
        patientSelect.innerHTML = '<option value="">Choose a patient...</option>';
        
        if (result.success && result.data.length > 0) {
          result.data.forEach(patient => {
            const option = document.createElement('option');
            option.value = patient.id;
            option.textContent = `P${patient.id.toString().padStart(3, '0')} - ${patient.first_name} ${patient.last_name} (${patient.status}${patient.room ? ', Room ' + patient.room : ''})`;
            patientSelect.appendChild(option);
          });
        } else {
          patientSelect.innerHTML = '<option value="">No patients assigned to you</option>';
        }
      } catch (error) {
        console.error('Error loading patients:', error);
        document.getElementById('patientSelect').innerHTML = '<option value="">Error loading patients</option>';
      }
    }

    function closeNewPrescriptionModal() {
      document.getElementById('newPrescriptionModal').style.display = 'none';
      document.getElementById('newPrescriptionForm').reset();
    }

    // Form submission
    document.getElementById('newPrescriptionForm').addEventListener('submit', async function(e) {
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

      // Extract patient name from the selected option text
      const selectedPatientText = patientSelect.options[patientSelect.selectedIndex].text;
      const patientName = selectedPatientText.split(' - ')[1].split(' (')[0]; // Extract name before status info
      
      // Prepare prescription data for backend submission
      const prescriptionData = {
        patient_id: patientSelect.value,
        patient_name: patientName,
        medication_name: medicationSelect.value,
        dosage: dosage,
        frequency: frequency,
        duration: duration,
        priority: 'medium',
        notes: `Quantity: ${quantity}`
      };

      try {
        const response = await fetch('<?= base_url('api/prescriptions/create') ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams(prescriptionData)
        });
        
        const result = await response.json();
        
        if (result.success) {
          alert('Prescription created successfully!');
          closeNewPrescriptionModal();
          // Reload prescriptions to show the new one
          loadPrescriptions();
        } else {
          alert('Error: ' + (result.message || 'Failed to create prescription'));
        }
      } catch (error) {
        console.error('Error creating prescription:', error);
        alert('Network error. Please try again.');
      }
    });

    // Edit prescription function
    async function editPrescription(prescriptionId) {
      try {
        // Fetch prescription details
        const response = await fetch(`<?= base_url('api/prescriptions/show/') ?>${prescriptionId}`);
        const result = await response.json();
        
        if (result.success) {
          const prescription = result.data;
          
          // Populate edit form
          document.getElementById('editPrescriptionId').value = prescription.id;
          document.getElementById('editMedicationSelect').value = prescription.medication_name;
          document.getElementById('editDosage').value = prescription.dosage;
          document.getElementById('editFrequency').value = prescription.frequency;
          document.getElementById('editDuration').value = prescription.duration;
          document.getElementById('editStatus').value = prescription.status;
          document.getElementById('editInstructions').value = prescription.notes || '';
          
          // Load patients and set selected patient
          await loadAssignedPatientsForEdit();
          document.getElementById('editPatientSelect').value = prescription.patient_id;
          
          // Show modal
          document.getElementById('editPrescriptionModal').style.display = 'block';
        } else {
          alert('Error loading prescription: ' + result.message);
        }
      } catch (error) {
        console.error('Error loading prescription:', error);
        alert('Network error. Please try again.');
      }
    }

    // Load patients for edit modal
    async function loadAssignedPatientsForEdit() {
      try {
        const response = await fetch('<?= base_url('api/prescriptions/assigned-patients') ?>');
        const result = await response.json();
        
        const patientSelect = document.getElementById('editPatientSelect');
        patientSelect.innerHTML = '<option value="">Choose a patient...</option>';
        
        if (result.success && result.data.length > 0) {
          result.data.forEach(patient => {
            const option = document.createElement('option');
            option.value = patient.id;
            option.textContent = `P${patient.id.toString().padStart(3, '0')} - ${patient.first_name} ${patient.last_name} (${patient.status}${patient.room ? ', Room ' + patient.room : ''})`;
            patientSelect.appendChild(option);
          });
        }
      } catch (error) {
        console.error('Error loading patients for edit:', error);
      }
    }

    // Close edit modal
    function closeEditPrescriptionModal() {
      document.getElementById('editPrescriptionModal').style.display = 'none';
      document.getElementById('editPrescriptionForm').reset();
    }

    // Handle edit form submission
    document.getElementById('editPrescriptionForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const prescriptionId = document.getElementById('editPrescriptionId').value;
      const patientSelect = document.getElementById('editPatientSelect');
      const medicationSelect = document.getElementById('editMedicationSelect');
      const dosage = document.getElementById('editDosage').value;
      const frequency = document.getElementById('editFrequency').value;
      const duration = document.getElementById('editDuration').value;
      const status = document.getElementById('editStatus').value;
      const instructions = document.getElementById('editInstructions').value;

      if (!patientSelect.value || !medicationSelect.value || !dosage || !frequency || !duration) {
        alert('Please fill in all required fields.');
        return;
      }

      // Extract patient name from the selected option text
      const selectedPatientText = patientSelect.options[patientSelect.selectedIndex].text;
      const patientName = selectedPatientText.split(' - ')[1].split(' (')[0];
      
      const prescriptionData = {
        patient_id: patientSelect.value,
        patient_name: patientName,
        medication_name: medicationSelect.value,
        dosage: dosage,
        frequency: frequency,
        duration: duration,
        status: status,
        notes: instructions
      };

      try {
        const response = await fetch(`<?= base_url('api/prescriptions/update/') ?>${prescriptionId}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams(prescriptionData)
        });
        
        const result = await response.json();
        
        if (result.success) {
          alert('Prescription updated successfully!');
          closeEditPrescriptionModal();
          loadPrescriptions();
        } else {
          alert('Error: ' + (result.message || 'Failed to update prescription'));
        }
      } catch (error) {
        console.error('Error updating prescription:', error);
        alert('Network error. Please try again.');
      }
    });

    // Delete prescription function
    async function deletePrescription(prescriptionId) {
      if (!confirm('Are you sure you want to delete this prescription? This action cannot be undone.')) {
        return;
      }

      try {
        const response = await fetch(`<?= base_url('api/prescriptions/delete/') ?>${prescriptionId}`, {
          method: 'POST'
        });
        
        const result = await response.json();
        
        if (result.success) {
          alert('Prescription deleted successfully!');
          loadPrescriptions();
        } else {
          alert('Error: ' + (result.message || 'Failed to delete prescription'));
        }
      } catch (error) {
        console.error('Error deleting prescription:', error);
        alert('Network error. Please try again.');
      }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      const newModal = document.getElementById('newPrescriptionModal');
      const editModal = document.getElementById('editPrescriptionModal');
      
      if (event.target === newModal) {
        closeNewPrescriptionModal();
      } else if (event.target === editModal) {
        closeEditPrescriptionModal();
      }
    }
  </script>
</body>
</html>