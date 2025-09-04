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
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .sidebar-header h4 {
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background-color: #ccc;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #666;
        }

        .sidebar-header p {
            font-size: 12px;
            margin-bottom: 5px;
        }

        .sidebar-header small {
            font-size: 10px;
            opacity: 0.8;
        }

        .nav-menu ul {
            list-style: none;
        }

        .nav-menu li {
            margin-bottom: 3px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background-color 0.3s;
            font-size: 12px;
        }

        .nav-menu a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .nav-menu a.active {
            background-color: rgba(255,255,255,0.2);
        }

        .nav-menu i {
            margin-right: 8px;
            width: 14px;
            font-size: 12px;
        }

        .logout-section {
            position: absolute;
            bottom: 15px;
            left: 15px;
            right: 15px;
        }

        .logout-section a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            border: 1px solid white;
            border-radius: 6px;
            transition: background-color 0.3s;
            font-size: 12px;
        }

        .logout-section a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        /* Main Content */
        .main-content {
            margin-left: 300px;
            padding: 20px;
            min-height: 100vh;
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
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .profile-form {
            background-color: #052719;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
            color: white;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #14524a;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary:hover {
            background-color: #0f3d37;
        }

        .alert {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
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
</body>
</html>
