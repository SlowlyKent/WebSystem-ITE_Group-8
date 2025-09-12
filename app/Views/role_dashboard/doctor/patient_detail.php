<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - HMS</title>
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
            margin: 15px;
            height: calc(100vh - 30px);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
        }

        /* Main Content */
        .main-content {
            margin-left: 300px;
            padding: 20px;
            min-height: 100vh;
            width: calc(100% - 340px);
        }

        .page-header {
            background-color: #052719;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            font-size: 24px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .patient-detail-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-card {
            background-color: #052719;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .info-card h3 {
            color: white;
            margin-bottom: 15px;
            font-size: 18px;
            border-bottom: 2px solid #b9d3c9;
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            color: #b9d3c9;
            width: 120px;
            flex-shrink: 0;
        }

        .info-value {
            color: white;
            flex: 1;
        }

        .patient-header {
            background-color: #052719;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .patient-avatar-large {
            width: 80px;
            height: 80px;
            background-color: #052719;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .patient-basic-info h2 {
            color: white;
            margin-bottom: 5px;
        }

        .patient-basic-info p {
            color: #b9d3c9;
            margin-bottom: 3px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            margin-top: 5px;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-discharged {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-admitted {
            background-color: #fff3cd;
            color: #856404;
        }

        .full-width-card {
            grid-column: 1 / -1;
        }

        .notes-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-top: 10px;
        }

        .notes-section h4 {
            color: #1b5e20;
            margin-bottom: 10px;
        }

        /* Action Buttons */
        .action-buttons-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .action-btn {
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            transition: all 0.3s ease;
            min-width: 180px;
            text-align: center;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        @media (max-width: 768px) {
            .action-buttons-container {
                flex-direction: column;
                align-items: center;
            }
            
            .action-btn {
                width: 100%;
                max-width: 300px;
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 0;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            background-color: #052719;
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 18px;
        }

        .close {
            color: white;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }

        .close:hover {
            opacity: 0.7;
        }

        .modal-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #052719;
            box-shadow: 0 0 5px rgba(5, 39, 25, 0.3);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }

        .btn-submit {
            background-color: #052719;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #041f15;
        }

        .patient-info-header {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <?= $this->include('role_dashboard/doctor/_doctor_sidebar') ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-user-injured"></i> Patient Details</h1>
            <a href="<?= base_url('doctor/patients') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Patient Records
            </a>
        </div>

        <!-- Patient Header -->
        <div class="patient-header">
            <div class="patient-avatar-large">
                <?= strtoupper(substr($patient['first_name'], 0, 1) . substr($patient['last_name'], 0, 1)) ?>
            </div>
            <div class="patient-basic-info">
                <h2><?= esc($patient['first_name'] . ' ' . ($patient['middle_name'] ? $patient['middle_name'] . ' ' : '') . $patient['last_name']) ?></h2>
                <p><strong>Patient ID:</strong> <?= esc($patient['id']) ?></p>
                <p><strong>Date of Birth:</strong> <?= esc($patient['date_of_birth'] ?? 'N/A') ?></p>
                <p><strong>Gender:</strong> <?= esc($patient['gender'] ?? 'N/A') ?></p>
                <span class="status-badge status-<?= strtolower($patient['status'] ?? 'active') ?>">
                    <?= esc($patient['status'] ?? 'Active') ?>
                </span>
            </div>
        </div>

        <!-- Patient Details Grid -->
        <div class="patient-detail-container">
            <!-- Contact Information -->
            <div class="info-card">
                <h3><i class="fas fa-address-book"></i> Contact Information</h3>
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value"><?= esc($patient['phone'] ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value"><?= esc($patient['email'] ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Address:</div>
                    <div class="info-value"><?= esc($patient['address'] ?? 'N/A') ?></div>
                </div>
            </div>

            <!-- Hospital Information -->
            <div class="info-card">
                <h3><i class="fas fa-hospital"></i> Hospital Information</h3>
                <div class="info-row">
                    <div class="info-label">Room:</div>
                    <div class="info-value"><?= esc($patient['room'] ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value"><?= esc($patient['status'] ?? 'Active') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Admitted:</div>
                    <div class="info-value">
                        <?php 
                        if (!empty($patient['created_at'])) {
                            $date = new DateTime($patient['created_at']);
                            echo $date->format('M d, Y H:i');
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <?php if ($emergency_contact): ?>
            <div class="info-card">
                <h3><i class="fas fa-phone-alt"></i> Emergency Contact</h3>
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value"><?= esc($emergency_contact['name']) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Relation:</div>
                    <div class="info-value"><?= esc($emergency_contact['relation']) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value"><?= esc($emergency_contact['phone']) ?></div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Medical Information -->
            <?php if ($medical_info): ?>
            <div class="info-card">
                <h3><i class="fas fa-heartbeat"></i> Medical Information</h3>
                <div class="info-row">
                    <div class="info-label">Blood Type:</div>
                    <div class="info-value"><?= esc($medical_info['blood_type'] ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Allergies:</div>
                    <div class="info-value"><?= esc($medical_info['allergies'] ?? 'None') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Conditions:</div>
                    <div class="info-value"><?= esc($medical_info['existing_condition'] ?? 'None') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Primary Physician:</div>
                    <div class="info-value"><?= esc($medical_info['primary_physician'] ?? 'N/A') ?></div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Insurance Information -->
            <?php if ($insurance): ?>
            <div class="info-card">
                <h3><i class="fas fa-shield-alt"></i> Insurance Information</h3>
                <div class="info-row">
                    <div class="info-label">Provider:</div>
                    <div class="info-value"><?= esc($insurance['provider']) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Policy Number:</div>
                    <div class="info-value"><?= esc($insurance['policy']) ?></div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Medical Notes -->
            <?php if (!empty($patient['medical_notes'])): ?>
            <div class="info-card full-width-card">
                <h3><i class="fas fa-notes-medical"></i> Medical Notes</h3>
                <div class="notes-section">
                    <?= nl2br(esc($patient['medical_notes'])) ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons-container">
            <button class="btn btn-primary action-btn" onclick="addNewNote()">
                <i class="fas fa-plus"></i> Add New Note +
            </button>
            <button class="btn btn-info action-btn" onclick="orderLabRequest()">
                <i class="fas fa-flask"></i> Order Lab Request +
            </button>
            <button class="btn btn-warning action-btn" onclick="prescribeMed()">
                <i class="fas fa-prescription-bottle"></i> Prescribed Med +
            </button>
        </div>

        <!-- Add New Notes Modal -->
        <div id="addNotesModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Add New Notes - <?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?></h3>
                    <span class="close" onclick="closeModal('addNotesModal')">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="patient-info-header">
                        Date: <?= date('m/d/Y') ?> &nbsp;&nbsp;&nbsp; Time: <?= date('h:i A') ?>
                    </div>
                    <form id="addNotesForm">
                        <div class="form-group">
                            <label for="notes">Notes:</label>
                            <textarea id="notes" name="notes" class="form-control" placeholder="Enter medical notes here..." required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('addNotesModal')">Cancel</button>
                    <button type="button" class="btn-submit" onclick="saveNotes()">Save Note</button>
                </div>
            </div>
        </div>

        <!-- Prescribe Medication Modal -->
        <div id="prescribeMedModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Prescribe Medication - <?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?></h3>
                    <span class="close" onclick="closeModal('prescribeMedModal')">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="patient-info-header">
                        Date: <?= date('m/d/Y') ?>
                    </div>
                    <form id="prescribeMedForm">
                        <div class="form-group">
                            <label for="selectTest">Select Test:</label>
                            <input type="text" id="selectTest" name="selectTest" class="form-control" placeholder="Enter medication name">
                        </div>
                        <div class="form-group">
                            <label for="options">Options:</label>
                            <input type="text" id="options" name="options" class="form-control" placeholder="Dosage, frequency, etc.">
                        </div>
                        <div class="form-group">
                            <label for="priority">Priority:</label>
                            <select id="priority" name="priority" class="form-control">
                                <option value="">Select Priority</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('prescribeMedModal')">Cancel</button>
                    <button type="button" class="btn-submit" onclick="submitOrder()">Submit Order</button>
                </div>
            </div>
        </div>

        <!-- Order Laboratory Test Modal -->
        <div id="orderLabModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Order Laboratory Test - <?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?></h3>
                    <span class="close" onclick="closeModal('orderLabModal')">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="patient-info-header">
                        Date: <?= date('m/d/Y') ?>
                    </div>
                    <form id="orderLabForm">
                        <div class="form-group">
                            <label for="medicine">Medicine:</label>
                            <input type="text" id="medicine" name="medicine" class="form-control" placeholder="Enter test name">
                        </div>
                        <div class="form-group">
                            <label for="frequency">Frequency:</label>
                            <input type="text" id="frequency" name="frequency" class="form-control" placeholder="How often">
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration:</label>
                            <input type="text" id="duration" name="duration" class="form-control" placeholder="Duration of test">
                        </div>
                        <div class="form-group">
                            <label for="labNotes">Notes:</label>
                            <textarea id="labNotes" name="labNotes" class="form-control" placeholder="Additional notes"></textarea>
                        </div>
                        <button type="button" class="btn btn-info" style="margin-top: 10px;">Add New Medicine +</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('orderLabModal')">Cancel</button>
                    <button type="button" class="btn-submit" onclick="savePrescription()">Save Prescription</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addNewNote() {
            document.getElementById('addNotesModal').style.display = 'block';
        }

        function orderLabRequest() {
            document.getElementById('orderLabModal').style.display = 'block';
        }

        function prescribeMed() {
            document.getElementById('prescribeMedModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function saveNotes() {
            const notes = document.getElementById('notes').value;
            if (!notes.trim()) {
                alert('Please enter notes before saving.');
                return;
            }
            
            // Here you would typically send the data to the server
            // console.log('Saving notes:', notes);
            alert('Notes saved successfully!');
            closeModal('addNotesModal');
            document.getElementById('addNotesForm').reset();
        }

        async function submitOrder() {
            const selectTest = document.getElementById('selectTest').value;
            const options = document.getElementById('options').value;
            const priority = document.getElementById('priority').value;
            
            if (!selectTest.trim()) {
                alert('Please enter medication name.');
                return;
            }
            
            // Prepare prescription data for backend submission
            const prescriptionData = {
                patient_id: '<?= $patient['id'] ?>',
                patient_name: '<?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?>',
                medication_name: selectTest,
                dosage: options,
                frequency: 'As prescribed',
                duration: 'As needed',
                priority: priority,
                notes: 'Prescribed from patient detail page'
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
                    alert('Prescription order submitted successfully! You can view it in the Prescriptions page.');
                    closeModal('prescribeMedModal');
                    document.getElementById('prescribeMedForm').reset();
                } else {
                    alert('Error: ' + (result.message || 'Failed to submit prescription'));
                }
            } catch (error) {
                console.error('Error submitting prescription:', error);
                alert('Network error. Please try again.');
            }
        }

        function savePrescription() {
            const medicine = document.getElementById('medicine').value;
            const frequency = document.getElementById('frequency').value;
            const duration = document.getElementById('duration').value;
            const labNotes = document.getElementById('labNotes').value;
            
            if (!medicine.trim()) {
                alert('Please enter test name.');
                return;
            }
            
            // Here you would typically send the data to the server
            // console.log('Saving lab test:', { medicine, frequency, duration, labNotes });
            alert('Laboratory test order saved successfully!');
            closeModal('orderLabModal');
            document.getElementById('orderLabForm').reset();
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modals = ['addNotesModal', 'prescribeMedModal', 'orderLabModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    closeModal(modalId);
                }
            });
        }
    </script>
</body>
</html>
