<?= $this->extend('role_dashboard/receptionist/layout') ?>
<?= $this->section('content') ?>

<style>
    /* Two-column layout */
    .appointment-container {
        display: flex;
        gap: 30px;
        padding: 20px;
    }

    /* Left sticky form */
    .appointment-left {
        flex: 1;
        max-width: 400px;
        position: sticky;
        top: 20px;
        align-self: flex-start;
    }

    .appointment-form {
        background: #052719;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .form-group {
        margin-bottom: 1.2rem;
    }

    label {
        color: white;
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .appointment-form .btn-success {
    background-color: white; 
    border: none;
    color: black;
    font-size: 1.1rem;
    transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .appointment-form .btn-success:hover {
        background: rgba(255, 255, 255, 0.33);
        transform: scale(1.05);
    }

    /* Right content box */
    .appointment-right {
        flex: 2;
    }

    .appointment-box {
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        color: black;
    }

    .appointment-box h3 {
        margin-bottom: 15px;
        color: black;
    }

    .appointment-table {
        width: 100%;
        border-collapse: collapse;
    }

    .appointment-table th,
    .appointment-table td {
        padding: 10px;
        border: 1px solid black;
        text-align: center;
    }

    .appointment-table th {
        background-color: #052719;
        color: white;
    }

    .appointment-table tbody tr {
        background-color: white; /* all rows solid white */
        color: black; /* make sure text stays visible */
    }

    .appointment-table tr:nth-child(even) {
        background-color: #f9f9f9; /* optional: add light gray striping */
    }

    /*notification for conflicts */
    .alert-box {
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 15px;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .error-box {
        background-color: #fdecea;
        border: 1px solid #f5c2c7;
        color: #842029;
    }

    .error-box ul {
        margin: 8px 0 0 18px;
        padding: 0;
    }

    .error-box li {
        margin-bottom: 4px;
    }
</style>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert-box error-box">
        <p><strong><?= esc(session()->getFlashdata('error')) ?></strong></p>
        
        <?php if (session()->getFlashdata('conflicts')): ?>
            <ul>
                <?php foreach (session()->getFlashdata('conflicts') as $c): ?>
                    <li>
                        <?= esc($c['patient']) ?> is booked on 
                        <?= esc($c['date']) ?> at <?= esc($c['time']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="appointment-container">
    <!-- Left: Sticky Form -->
    <div class="appointment-left">
        <form method="post" action="<?= base_url('role_dashboard/receptionist/saveAppointment') ?>" class="appointment-form">
            <div class="form-group">
                <label>Patient ID</label>
                <input type="text" name="patient_id" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Doctor</label>
                <select name="doctor_id" class="form-control" required>
                    <option value="">-- Select Doctor --</option>
                    <?php foreach($doctors as $doctor): ?>
                        <option value="<?= esc($doctor['id']) ?>">
                            <?= esc('Dr. ' . $doctor['first_name'] . ' ' . $doctor['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Time</label>
                <input type="time" name="time" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Type</label>
                <input type="text" name="appointment_type" class="form-control" placeholder="Check-up, Consultation..." required>
            </div>

            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>
            
            <button type="submit" class="btn btn-success">Book Appointment</button>
        </form>
    </div>

    <!-- Right: Appointments Tables -->
    <div class="appointment-right">
     <div class="appointments">
        <div class="appointment-box">
            <h3>Today's Appointments</h3>
            <table class="appointment-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($todayAppointments)): ?>
                        <?php foreach ($todayAppointments as $appt): ?>
                            <tr>
                                <td><?= esc($appt['patient_first_name'] . ' ' . $appt['patient_last_name']) ?></td>
                                <td><?= esc('Dr. ' . $appt['doctor_first_name'] . ' ' . $appt['doctor_last_name']) ?></td>
                                <td><?= esc($appt['appointment_time']) ?></td>
                                <td><?= esc($appt['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No appointments today.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

        <div class="appointment-box">
            <h3>Upcoming Appointments</h3>
            <table class="appointment-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($upcomingAppointments)): ?>
                        <?php foreach ($upcomingAppointments as $appt): ?>
                            <tr>
                                <td><?= esc($appt['patient_first_name'] . ' ' . $appt['patient_last_name']) ?></td>
                                <td><?= esc('Dr. ' . $appt['doctor_first_name'] . ' ' . $appt['doctor_last_name']) ?></td>
                                <td><?= esc($appt['appointment_date']) ?></td>
                                <td><?= esc($appt['appointment_time']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No upcoming appointments.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="appointment-box">
            <h3>Finished Appointments</h3>
            <table class="appointment-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($finishedAppointments)): ?>
                        <?php foreach ($finishedAppointments as $appt): ?>
                            <tr>
                                <td><?= esc($appt['first_name'] . ' ' . $appt['last_name']) ?></td>
                                <td><?= esc($appt['doctor']) ?></td>
                                <td><?= esc($appt['date']) ?></td>
                                <td><?= esc($appt['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No finished appointments yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

