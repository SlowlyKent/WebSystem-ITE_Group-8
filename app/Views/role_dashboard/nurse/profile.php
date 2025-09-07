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
            min-height: 100vh;
            width: 100%;
        }

        .dashboard {
            display: flex;
            width: 100%;
            min-height: 100vh; 
            background: #b9d3c9;
            padding: 0;
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
            overflow-y: auto;
        }

        /* Main Content */
        .main {
            flex: 1;
            padding: 40px 40px 40px 340px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-height: 100vh;
            width: 100%;
        }

        .main-header {
            background-color: #81c798;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 15px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
        }

        .header-left h1 {
            color: #052719;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header-left p {
            color: #052719;
            font-size: 14px;
        }

        /* Profile Section */
        .profile-section {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background-color: #052719;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            margin-right: 25px;
        }

        .profile-info h2 {
            color: #052719;
            margin: 0 0 8px 0;
            font-size: 28px;
        }

        .profile-info .role {
            color: #666;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .profile-info .status {
            display: inline-block;
            background: #00ff95;
            color: #052719;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Form Styles */
        .form-section {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-section h3 {
            color: #052719;
            margin-bottom: 20px;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #052719;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #052719;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn {
            background: #052719;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background: #0f6b45;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        /* Alert Messages */
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main {
                padding: 20px 20px 20px 320px;
            }
        }

        @media (max-width: 992px) {
            .dashboard {
                padding: 15px;
                flex-direction: column;
            }
            
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                margin: 0 0 20px 0;
                border-radius: 10px;
            }

            .main {
                width: 100%;
                padding: 15px;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar Navigation -->
        <?= $this->include('role_dashboard/nurse/_nurse_sidebar') ?>

        <!-- Main Content -->
        <main class="main">
            <header class="main-header">
                <div class="header-left">
                    <h1>Nurse Profile</h1>
                    <p>Manage your profile information</p>
                </div>
            </header>

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Profile Header -->
            <div class="profile-section">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <i class="fas fa-user-nurse"></i>
                    </div>
                    <div class="profile-info">
                        <h2><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></h2>
                        <div class="role">Registered Nurse</div>
                        <span class="status"><?= ucfirst(esc($user['status'])) ?></span>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="form-section">
                <h3><i class="fas fa-user-edit"></i> Personal Information</h3>
                <form action="<?= base_url('nurse/profile/update') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" 
                                   value="<?= esc($user['first_name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" 
                                   value="<?= esc($user['last_name']) ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" 
                               value="<?= esc($user['email']) ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" 
                                   value="<?= esc($user['username']) ?>" readonly 
                                   style="background-color: #f8f9fa; cursor: not-allowed;">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" id="role" name="role" 
                                   value="<?= ucfirst(esc($user['role'])) ?>" readonly 
                                   style="background-color: #f8f9fa; cursor: not-allowed;">
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; margin-top: 30px;">
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="togglePasswordForm()">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Change Form (Hidden by default) -->
            <div class="form-section" id="passwordForm" style="display: none;">
                <h3><i class="fas fa-key"></i> Change Password</h3>
                <form action="<?= base_url('nurse/profile/change-password') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" 
                                   minlength="6" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" 
                                   minlength="6" required>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; margin-top: 20px;">
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Change Password
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="togglePasswordForm()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Information -->
            <div class="form-section">
                <h3><i class="fas fa-info-circle"></i> Account Information</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <div>
                        <label style="display: block; color: #666; margin-bottom: 5px;">Account Created</label>
                        <div style="color: #052719; font-weight: 600;">
                            <?= date('F d, Y', strtotime($user['created_at'])) ?>
                        </div>
                    </div>
                    <div>
                        <label style="display: block; color: #666; margin-bottom: 5px;">Last Updated</label>
                        <div style="color: #052719; font-weight: 600;">
                            <?= date('F d, Y', strtotime($user['updated_at'])) ?>
                        </div>
                    </div>
                    <div>
                        <label style="display: block; color: #666; margin-bottom: 5px;">Account Status</label>
                        <div style="color: #052719; font-weight: 600;">
                            <?= ucfirst(esc($user['status'])) ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function togglePasswordForm() {
            const passwordForm = document.getElementById('passwordForm');
            if (passwordForm.style.display === 'none') {
                passwordForm.style.display = 'block';
                passwordForm.scrollIntoView({ behavior: 'smooth' });
            } else {
                passwordForm.style.display = 'none';
            }
        }

        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;
            
            if (newPassword !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>
