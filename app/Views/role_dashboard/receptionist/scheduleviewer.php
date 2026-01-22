<?= $this->extend('role_dashboard/receptionist/layout') ?>
<?= $this->section('content') ?>

<style>
    /* Tabs */
    .schedule-tabs {
        display: flex;
        gap: 10px;
        margin: 15px 0;
    }

    .schedule-tabs .tab-btn {
        padding: 8px 14px;
        border: 2px solid #052719;
        border-radius: 6px;
        background: transparent;
        font-weight: 600;
        cursor: pointer;
        color: #052719;
    }

    .schedule-tabs .tab-btn.active {
        background: #052719;
        color: #fff;
    }

    /* Schedule container */
    .schedule-content {
        background: #052719; 
        margin-top: 10px;
        padding: 20px;
    }

    /* Table */
    .table-content {
        margin: 20px auto;
    }

    .schedule-content table {
        width: 100%;
        border-collapse: collapse;
        font-size: 1rem;
        border: 2px solid white;
    }

    .schedule-content th,
    .schedule-content td {
        padding: 12px;
        border: 1px solid #ccc;
        text-align: center;
        color: white;
    }

    .schedule-content th {
        background: white;
        color: #052719;
    }

    .schedule-content tr:hover {
        background: #1484556e;
    }
</style>

<div class="schedule-tabs">
    <button type="button" class="tab-btn active" data-target="doctor">Doctor</button>
    <button type="button" class="tab-btn" data-target="nurse">Nurse</button>
</div>

<!-- Doctor Schedule -->
<div id="doctor" class="schedule-content active">
    <h3 style="color:white;">Doctor Schedules</h3>
    <table class="table-content">
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Title</th>
                <th>Date</th>
                <th>Time</th>
                <th>Type</th>
                <th>Status</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $doctorSchedules = array_filter($schedules, fn($s) => !empty($s['doctor_id']));
            ?>
            <?php if (!empty($doctorSchedules)): ?>
                <?php foreach ($doctorSchedules as $sch): ?>
                    <tr>
                        <td><?= esc($sch['doctor_first_name'].' '.$sch['doctor_last_name']) ?></td>
                        <td><?= esc($sch['title']) ?></td>
                        <td><?= esc($sch['schedule_date']) ?></td>
                        <td><?= esc($sch['start_time'].' - '.$sch['end_time']) ?></td>
                        <td><?= esc(ucfirst($sch['schedule_type'])) ?></td>
                        <td><?= esc(ucfirst($sch['status'])) ?></td>
                        <td><?= esc($sch['location']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7">No doctor schedules available.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Nurse Schedule -->
<div id="nurse" class="schedule-content" style="display:none;">
    <h3 style="color:white;">Nurse Schedules</h3>
    <table class="table-content">
        <thead>
            <tr>
                <th>Nurse</th>
                <th>Title</th>
                <th>Date</th>
                <th>Time</th>
                <th>Type</th>
                <th>Status</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $nurseSchedules = array_filter($schedules, fn($s) => !empty($s['nurse_id']));
            ?>
            <?php if (!empty($nurseSchedules)): ?>
                <?php foreach ($nurseSchedules as $sch): ?>
                    <tr>
                        <td><?= esc($sch['nurse_first_name'].' '.$sch['nurse_last_name']) ?></td>
                        <td><?= esc($sch['title']) ?></td>
                        <td><?= esc($sch['schedule_date']) ?></td>
                        <td><?= esc($sch['start_time'].' - '.$sch['end_time']) ?></td>
                        <td><?= esc(ucfirst($sch['schedule_type'])) ?></td>
                        <td><?= esc(ucfirst($sch['status'])) ?></td>
                        <td><?= esc($sch['location']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7">No nurse schedules available.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    // Toggle tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.schedule-content').forEach(c => c.style.display = 'none');
            
            this.classList.add('active');
            document.getElementById(this.dataset.target).style.display = 'block';
        });
    });
</script>

<?= $this->endSection() ?>