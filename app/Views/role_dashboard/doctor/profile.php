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
  <div class="dashboard">
    <!-- Sidebar Navigation -->
    <?= $this->include('role_dashboard/doctor/_doctor_sidebar') ?>

    <!-- Main Content -->
    <div class="main-content">
      <div class="page-header">
        <h1>Doctor Profile</h1>
        <a href="<?= base_url('doctor/dashboard') ?>" class="btn btn-secondary">
          &larr; Return to Dashboard
        </a>
      </div>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
          <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
          <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <p><?= $error ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="post" action="<?= base_url('doctor/profile') ?>" class="profile-form">
        <?= csrf_field() ?>

        <div class="form-group">
          <label>First Name:</label>
          <input type="text" name="first_name" value="<?= old('first_name', $user['first_name']) ?>" required>
        </div>

        <div class="form-group">
          <label>Last Name:</label>
          <input type="text" name="last_name" value="<?= old('last_name', $user['last_name']) ?>" required>
        </div>

        <div class="form-group">
          <label>Email:</label>
          <input type="email" name="email" value="<?= old('email', $user['email']) ?>" required>
        </div>

        <div class="form-group">
          <label>Username:</label>
          <input type="text" value="<?= $user['username'] ?>" readonly style="background-color: #f8f9fa; color: #6c757d;">
          <small style="color: #c8e6c9; font-size: 12px;">Username cannot be changed</small>
        </div>

        <div class="form-group">
          <label>Role:</label>
          <input type="text" value="<?= ucfirst($user['role']) ?>" readonly style="background-color: #f8f9fa; color: #6c757d;">
        </div>

        <button type="submit" class="btn-primary">Update Profile</button>
      </form>
    </div>
  </div>
</body>
</html>
