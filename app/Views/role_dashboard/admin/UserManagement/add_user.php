<?= $this->extend('role_dashboard/admin/_layout') ?>

<?= $this->section('sidebar') ?>
    <?= $this->include('role_dashboard/admin/dashboard/_sidebar') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-header" style="background-color: #18332c; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
    <h1>Add New User</h1>
    <a href="<?= base_url('user-management') ?>" class="btn btn-secondary" style="float: right; margin-top: -40px;">
        &larr; Return to User Table
    </a>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <p class="error" style="color: red; margin-bottom: 15px;"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger" style="color: red; margin-bottom: 15px;">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= base_url('user-management/create') ?>" style="background-color: #18332c; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; color: white;">
    <?= csrf_field() ?>
    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <div style="flex: 1 1 45%;">
            <label>First Name:</label>
            <input type="text" name="first_name" value="<?= old('first_name') ?>" required style="width: 100%; padding: 8px; border-radius: 4px; border: none;">
            <?php if (isset($errors['first_name'])): ?>
                <div class="error" style="color: #ff6b6b;"><?= $errors['first_name'] ?></div>
            <?php endif; ?>
        </div>
        <div style="flex: 1 1 45%;">
            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?= old('last_name') ?>" required style="width: 100%; padding: 8px; border-radius: 4px; border: none;">
            <?php if (isset($errors['last_name'])): ?>
                <div class="error" style="color: #ff6b6b;"><?= $errors['last_name'] ?></div>
            <?php endif; ?>
        </div>
        <div style="flex: 1 1 45%;">
            <label>Email:</label>
            <input type="email" name="email" value="<?= old('email') ?>" required style="width: 100%; padding: 8px; border-radius: 4px; border: none;">
            <?php if (isset($errors['email'])): ?>
                <div class="error" style="color: #ff6b6b;"><?= $errors['email'] ?></div>
            <?php endif; ?>
        </div>
        <div style="flex: 1 1 45%;">
            <label>Username:</label>
            <input type="text" name="username" value="<?= old('username') ?>" required style="width: 100%; padding: 8px; border-radius: 4px; border: none;">
            <?php if (isset($errors['username'])): ?>
                <div class="error" style="color: #ff6b6b;"><?= $errors['username'] ?></div>
            <?php endif; ?>
        </div>
        <div style="flex: 1 1 45%;">
            <label>Password:</label>
            <input type="password" name="password" value="<?= old('password') ?>" required style="width: 100%; padding: 8px; border-radius: 4px; border: none;">
            <?php if (isset($errors['password'])): ?>
                <div class="error" style="color: #ff6b6b;"><?= $errors['password'] ?></div>
            <?php endif; ?>
        </div>
        <div style="flex: 1 1 45%;">
            <label>Role:</label>
            <select name="role" required style="width: 100%; padding: 8px; border-radius: 4px; border: none;">
                <?php if (session()->get('role') == 'admin'): ?>
                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                <?php endif; ?>
                <option value="it_staff" <?= old('role') == 'it_staff' ? 'selected' : '' ?>>IT Staff</option>
                <option value="doctor" <?= old('role') == 'doctor' ? 'selected' : '' ?>>Doctor</option>
                <option value="nurse" <?= old('role') == 'nurse' ? 'selected' : '' ?>>Nurse</option>
                <option value="laboratory_staff" <?= old('role') == 'laboratory_staff' ? 'selected' : '' ?>>Laboratory Staff</option>
                <option value="receptionist" <?= old('role') == 'receptionist' ? 'selected' : '' ?>>Receptionist</option>
                <option value="pharmacist" <?= old('role') == 'pharmacist' ? 'selected' : '' ?>>Pharmacist</option>
                <option value="accountant" <?= old('role') == 'accountant' ? 'selected' : '' ?>>Accountant</option>
            </select>
        </div>
    </div>
    <button type="submit" style="margin-top: 20px; background-color: #14524a; padding: 10px 20px; border: none; border-radius: 4px; color: white;">Create User</button>
</form>
<?= $this->endSection() ?>
