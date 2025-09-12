<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= isset($title) ? esc($title) . ' - HMS' : 'HMS' ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet" />
    <script src="<?= base_url('assets/js/script.js') ?>" defer></script>
</head>
<body>
    <?= $this->include('role_dashboard/admin/dashboard/_sidebar') ?>

    <div class="main-content">
        <div class="page-header">
            <h1><i class="fa-solid fa-calendar-days"></i> Doctor Scheduling</h1>
            <a href="#" class="btn btn-primary" onclick="toggleScheduleForm()">+ Add Schedule</a>
        </div>

        <!-- Schedule Table -->
        <div class="patient-table-container">
            <table class="patient-table">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Time Slot</th>
                        <th>Type</th>
                        <th>Patient</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="scheduleTable">
                    <?php if (!empty($schedules)): ?>
                        <?php foreach ($schedules as $schedule): ?>
                            <tr>
                                <td>Dr. <?= esc($schedule['doctor_first_name']) ?> <?= esc($schedule['doctor_last_name']) ?></td>
                                <td><?= esc($schedule['description']) ?></td>
                                <td><?= date('M d, Y', strtotime($schedule['schedule_date'])) ?></td>
                                <td><?= date('H:i', strtotime($schedule['start_time'])) ?> - <?= date('H:i', strtotime($schedule['end_time'])) ?></td>
                                <td><span class="badge badge-<?= $schedule['schedule_type'] ?>"><?= ucfirst($schedule['schedule_type']) ?></span></td>
                                <td>
                                    <?php if ($schedule['patient_first_name']): ?>
                                        <?= esc($schedule['patient_first_name']) ?> <?= esc($schedule['patient_last_name']) ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($schedule['location'] ?? '-') ?></td>
                                <td>
                                    <button onclick="editSchedule(<?= $schedule['id'] ?>)" class="action-btn edit-btn" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <a href="<?= base_url('scheduling/delete/' . $schedule['id']) ?>" class="action-btn delete-btn" title="Delete" 
                                       onclick="return confirm('Are you sure you want to delete this schedule?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No schedules found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Add Schedule Form (hidden by default) -->
        <div class="form-container" id="scheduleForm" style="display:none; margin-top:20px;">
            <form action="<?= base_url('scheduling/add') ?>" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="doctor_id">Doctor <span class="required">*</span></label>
                        <select name="doctor_id" id="doctor_id" required>
                            <option value="">-- Select Doctor --</option>
                            <?php if (!empty($doctors)): ?>
                                <?php foreach ($doctors as $doctor): ?>
                                    <option value="<?= $doctor['id'] ?>">
                                        Dr. <?= esc($doctor['first_name']) ?> <?= esc($doctor['last_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="required">*</span></label>
                        <input type="text" name="description" id="description" required placeholder="e.g., Morning Consultation">
                    </div>
                    <div class="form-group">
                        <label for="schedule_date">Date <span class="required">*</span></label>
                        <input type="date" name="schedule_date" id="schedule_date" required>
                    </div>
                    <div class="form-group">
                        <label for="start_time">Start Time <span class="required">*</span></label>
                        <input type="time" name="start_time" id="start_time" required>
                    </div>
                    <div class="form-group">
                        <label for="end_time">End Time <span class="required">*</span></label>
                        <input type="time" name="end_time" id="end_time" required>
                    </div>
                    <div class="form-group">
                        <label for="schedule_type">Type <span class="required">*</span></label>
                        <select name="schedule_type" id="schedule_type" required>
                            <option value="consultation">Consultation</option>
                            <option value="surgery">Surgery</option>
                            <option value="rounds">Rounds</option>
                            <option value="emergency">Emergency</option>
                            <option value="meeting">Meeting</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" id="location" placeholder="e.g., Room 101">
                    </div>
                    <div class="form-group">
                        <label for="patient_id">Patient (Optional)</label>
                        <select name="patient_id" id="patient_id">
                            <option value="">-- No Patient Assigned --</option>
                            <?php if (!empty($patients)): ?>
                                <?php foreach ($patients as $patient): ?>
                                    <option value="<?= $patient['id'] ?>">
                                        <?= esc($patient['first_name']) ?> <?= esc($patient['last_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Schedule</button>
                    <button type="button" class="btn btn-secondary" onclick="toggleScheduleForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Schedule Modal -->
    <div id="editModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Schedule</h3>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <form id="editScheduleForm" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit_doctor_id">Doctor <span class="required">*</span></label>
                        <select name="doctor_id" id="edit_doctor_id" required>
                            <option value="">-- Select Doctor --</option>
                            <?php if (!empty($doctors)): ?>
                                <?php foreach ($doctors as $doctor): ?>
                                    <option value="<?= $doctor['id'] ?>">Dr. <?= esc($doctor['first_name']) ?> <?= esc($doctor['last_name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_description">Description <span class="required">*</span></label>
                        <input type="text" name="description" id="edit_description" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_schedule_date">Date <span class="required">*</span></label>
                        <input type="date" name="schedule_date" id="edit_schedule_date" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_start_time">Start Time <span class="required">*</span></label>
                        <input type="time" name="start_time" id="edit_start_time" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_end_time">End Time <span class="required">*</span></label>
                        <input type="time" name="end_time" id="edit_end_time" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_schedule_type">Type <span class="required">*</span></label>
                        <select name="schedule_type" id="edit_schedule_type" required>
                            <option value="">-- Select Type --</option>
                            <option value="consultation">Consultation</option>
                            <option value="surgery">Surgery</option>
                            <option value="rounds">Rounds</option>
                            <option value="emergency">Emergency</option>
                            <option value="meeting">Meeting</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_patient_id">Patient (Optional)</label>
                        <select name="patient_id" id="edit_patient_id">
                            <option value="">-- Select Patient --</option>
                            <?php if (!empty($patients)): ?>
                                <?php foreach ($patients as $patient): ?>
                                    <option value="<?= $patient['id'] ?>"><?= esc($patient['first_name']) ?> <?= esc($patient['last_name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_location">Location</label>
                        <input type="text" name="location" id="edit_location" placeholder="Room/Department">
                    </div>

                    <div class="form-group full-width">
                        <label for="edit_notes">Notes</label>
                        <textarea name="notes" id="edit_notes" rows="3" placeholder="Additional notes..."></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Schedule</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .modal {
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
            border: none;
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
        }

        .close {
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }

        .close:hover {
            opacity: 0.7;
        }

        .modal .form-grid {
            padding: 20px;
        }

        .form-actions {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            text-align: right;
        }

        .form-actions .btn {
            margin-left: 10px;
        }
    </style>

    <script>
        // Simple JS to toggle form
        function toggleScheduleForm() {
            const form = document.getElementById('scheduleForm');
            form.style.display = form.style.display === "none" ? "block" : "none";
        }

        // Edit schedule function
        function editSchedule(scheduleId) {
            // Fetch schedule data
            fetch(`<?= base_url('scheduling/get/') ?>${scheduleId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const schedule = data.schedule;
                        
                        // Populate form fields
                        document.getElementById('edit_doctor_id').value = schedule.doctor_id;
                        document.getElementById('edit_description').value = schedule.description;
                        document.getElementById('edit_schedule_date').value = schedule.schedule_date;
                        document.getElementById('edit_start_time').value = schedule.start_time;
                        document.getElementById('edit_end_time').value = schedule.end_time;
                        document.getElementById('edit_schedule_type').value = schedule.schedule_type;
                        document.getElementById('edit_patient_id').value = schedule.patient_id || '';
                        document.getElementById('edit_location').value = schedule.location || '';
                        document.getElementById('edit_notes').value = schedule.notes || '';
                        
                        // Update form action
                        document.getElementById('editScheduleForm').action = `<?= base_url('scheduling/update/') ?>${scheduleId}`;
                        
                        // Show modal
                        document.getElementById('editModal').style.display = 'block';
                    } else {
                        alert('Error loading schedule data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading schedule data');
                });
        }

        // Close modal function
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
