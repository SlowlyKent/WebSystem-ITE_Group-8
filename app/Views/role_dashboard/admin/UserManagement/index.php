
<?= $this->extend('role_dashboard/admin/_layout') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>User Management</h1>
    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary" style="float: left; margin-bottom: 10px; margin-right: 10px;">
        &larr; Return to Dashboard
    </a>
    <a href="<?= base_url('user-management/add') ?>" class="btn btn-primary" style="float: right; margin-bottom: 10px;">
        <i class="fas fa-user-plus"></i> Add New User
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="alert" style="margin-bottom: 15px;">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="patient-table-container">
<table class="patient-table" style="width: 100%;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= esc($user['id']) ?></td>
            <td><?= esc($user['username']) ?></td>
            <td><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></td>
            <td><?= esc($user['role']) ?></td>
            <td>
                <a href="<?= base_url('user-management/view/' . $user['id']) ?>" class="action-btn view-btn" style="margin-right: 5px;">
                    <i class="fas fa-eye"></i> View
                </a>
                <a href="<?= base_url('user-management/edit/' . $user['id']) ?>" class="action-btn edit-btn" style="margin-right: 5px;">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="<?= base_url('user-management/delete/' . $user['id']) ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">
                    <i class="fas fa-trash"></i> Delete
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?= $this->endSection() ?>