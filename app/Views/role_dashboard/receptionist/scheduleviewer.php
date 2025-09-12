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

    /* Schedule container bg */
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

    .scedule-content table {
        width: 100%;
        border-collapse: collapse;
        font-size: 1rem;
    }

    .schedule-content th,
    .schedule-content td {
        padding: 14px;
        border: 1px solid #ccc;
        text-align: center;
        color: white;
    }

    .schedule-content th {
        background: white;
        color: #052719;
    }

    .schedule-content tr:hover {
        background:  #1484556e;
    }
</style>

<div class="schedule-tabs">
    <button type="button" class="tab-btn active" data-target="doctor">Doctor</button>
    <button type="button" class="tab-btn" data-target="nurse">Nurse</button>
</div>

<!-- Doctor Schedule -->
<div id="doctor" class="schedule-content active">
    <h3 style="color:white;">Doctor Schedule</h3>
    <table class="table-content">
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Specialization</th>
                <th>Available Days</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($doctorSchedule)): ?>
                <?php foreach ($doctorSchedule as $doc): ?>
                    <tr>
                        <td><?= esc($doc['name']) ?></td>
                        <td><?= esc($doc['specialization']) ?></td>
                        <td><?= esc($doc['days']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3">No doctor schedules available.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Nurse Schedule -->
<div id="nurse" class="schedule-content" style="display:none;">
    <h3 style="color:white;">Nurse Schedule</h3>
    <table class = "table-content">
        <thead>
            <tr>
                <th>Nurse</th>
                <th>Shift</th>
                <th>Available Days</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($nurseSchedule)): ?>
                <?php foreach ($nurseSchedule as $nurse): ?>
                    <tr>
                        <td><?= esc($nurse['name']) ?></td>
                        <td><?= esc($nurse['shift']) ?></td>
                        <td><?= esc($nurse['days']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3">No nurse schedules available.</td></tr>
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
