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
