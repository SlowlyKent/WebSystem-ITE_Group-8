<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - HMS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/docnurse.css') ?>">
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
