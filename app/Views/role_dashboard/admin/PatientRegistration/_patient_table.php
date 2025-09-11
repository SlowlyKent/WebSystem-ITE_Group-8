<div class="patient-table-container">
    <?php if (!empty($patients)): ?>
        <table class="patient-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Status</th>
                    <th>Room</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= $patient['id'] ?></td>
                        <td><?= $patient['first_name'] ?></td>
                        <td><?= $patient['last_name'] ?></td>
                        <td><?= $patient['status'] ?></td>
                        <td><?= $patient['room'] ?? '—' ?></td>
                        <td>
                            <a href="<?= base_url('patients/view/' . $patient['id']) ?>" class="action-btn view-btn">View</a>
                            <a href="<?= base_url('patients/edit/' . $patient['id']) ?>" class="action-btn edit-btn">Edit</a>
                            <a href="<?= base_url('patients/delete/' . $patient['id']) ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this patient?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-user-friends"></i>
            <h3>No Patients Found</h3>
            <p>Start by adding your first patient to the system.</p>
        </div>
    <?php endif; ?>
</div>
