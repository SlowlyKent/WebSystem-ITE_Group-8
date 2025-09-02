<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($patient) ? 'Edit Patient' : 'Add New Patient' ?> - HMS</title>
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
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            color: white;
            font-size: 24px;
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        /* Form Container */
        .form-container {
            background-color: #052719;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 800px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            color: white;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #b9d3c9;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #b9d3c9;
            color: #052719;
        }

        .btn-primary:hover {
            background-color: #a8d5ba;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .required {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>HMS</h4>
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <p>Kent Felicia</p>
            <small>Hospital Administrator Dashboard</small>
        </div>

        <nav class="nav-menu">
            <ul>
                <li>
                    <a href="<?= base_url('dashboard') ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('patients') ?>" class="active">
                        <i class="fas fa-user-plus"></i>
                        Patient Registration & EHR
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-credit-card"></i>
                        Billing & Payment
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-chart-bar"></i>
                        Reports & Analytics
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-flask"></i>
                        Laboratory Management
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-pills"></i>
                        Pharmacy & Inventory
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-database"></i>
                        Database Status
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('user-management') ?>">
                        <i class="fas fa-users-cog"></i>
                        User Management
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-calendar-alt"></i>
                        Scheduling
                    </a>
                </li>
            </ul>
        </nav>

        <div class="logout-section">
            <a href="<?= base_url('logout') ?>">
                <i class="fas fa-sign-out-alt"></i>
                Log-out
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1><?= isset($patient) ? 'Edit Patient' : 'Add New Patient' ?></h1>
            <a href="<?= base_url('patients') ?>" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Patient List
            </a>
        </div>

        <div class="form-container">
            <form action="<?= isset($patient) ? base_url('patients/update/' . $patient['id']) : base_url('patients/store') ?>" method="post">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="first_name">First Name <span class="required">*</span></label>
                        <input type="text" id="first_name" name="first_name" value="<?= isset($patient) ? esc($patient['first_name']) : '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" value="<?= isset($patient) ? esc($patient['middle_name']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name <span class="required">*</span></label>
                        <input type="text" id="last_name" name="last_name" value="<?= isset($patient) ? esc($patient['last_name']) : '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="<?= isset($patient) ? esc($patient['date_of_birth']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male" <?= (isset($patient) && $patient['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= (isset($patient) && $patient['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                            <option value="Other" <?= (isset($patient) && $patient['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="<?= isset($patient) ? esc($patient['phone']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?= isset($patient) ? esc($patient['email']) : '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="status">Status <span class="required">*</span></label>
                        <select id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="Active" <?= (isset($patient) && $patient['status'] == 'Active') ? 'selected' : '' ?>>Active</option>
                            <option value="Inactive" <?= (isset($patient) && $patient['status'] == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                            <option value="Discharged" <?= (isset($patient) && $patient['status'] == 'Discharged') ? 'selected' : '' ?>>Discharged</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="room">Room Number</label>
                        <select id="room" name="room">
                            <option value="">Select Room</option>
                            <!-- EMM Rooms (001-010) -->
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="EMM-<?= sprintf('%03d', $i) ?>" <?= (isset($patient) && $patient['room'] == 'EMM-' . sprintf('%03d', $i)) ? 'selected' : '' ?>>EMM-<?= sprintf('%03d', $i) ?></option>
                            <?php endfor; ?>
                            <!-- AGM Rooms (011-020) -->
                            <?php for ($i = 11; $i <= 20; $i++): ?>
                                <option value="AGM-<?= sprintf('%03d', $i) ?>" <?= (isset($patient) && $patient['room'] == 'AGM-' . sprintf('%03d', $i)) ? 'selected' : '' ?>>AGM-<?= sprintf('%03d', $i) ?></option>
                            <?php endfor; ?>
                            <!-- FGM Rooms (021-030) -->
                            <?php for ($i = 21; $i <= 30; $i++): ?>
                                <option value="FGM-<?= sprintf('%03d', $i) ?>" <?= (isset($patient) && $patient['room'] == 'FGM-' . sprintf('%03d', $i)) ? 'selected' : '' ?>>FGM-<?= sprintf('%03d', $i) ?></option>
                            <?php endfor; ?>
                            <!-- Annex Rooms (031-040) -->
                            <?php for ($i = 31; $i <= 40; $i++): ?>
                                <option value="Annex-<?= sprintf('%03d', $i) ?>" <?= (isset($patient) && $patient['room'] == 'Annex-' . sprintf('%03d', $i)) ? 'selected' : '' ?>>Annex-<?= sprintf('%03d', $i) ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" placeholder="Enter complete address"><?= isset($patient) ? esc($patient['address']) : '' ?></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="medical_notes">Medical Notes</label>
                        <textarea id="medical_notes" name="medical_notes" placeholder="Any relevant medical information"><?= isset($patient) ? esc($patient['medical_notes']) : '' ?></textarea>
                    </div>

                    <!-- Insurance Information Section -->
                    <div class="form-group">
                        <label for="insurance_provider">Insurance Provider</label>
                        <input type="text" id="insurance_provider" name="insurance_provider" value="<?= isset($insurance) ? esc($insurance['provider']) : '' ?>" placeholder="e.g., Blue Cross, Aetna">
                    </div>

                    <div class="form-group">
                        <label for="insurance_policy">Policy Number</label>
                        <input type="text" id="insurance_policy" name="insurance_policy" value="<?= isset($insurance) ? esc($insurance['policy']) : '' ?>" placeholder="Insurance policy number">
                    </div>

                    <!-- Medical Information Section -->
                    <div class="form-group">
                        <label for="blood_type">Blood Type</label>
                        <select id="blood_type" name="blood_type">
                            <option value="">Select Blood Type</option>
                            <option value="A+" <?= (isset($medical_info) && $medical_info['blood_type'] == 'A+') ? 'selected' : '' ?>>A+</option>
                            <option value="A-" <?= (isset($medical_info) && $medical_info['blood_type'] == 'A-') ? 'selected' : '' ?>>A-</option>
                            <option value="B+" <?= (isset($medical_info) && $medical_info['blood_type'] == 'B+') ? 'selected' : '' ?>>B+</option>
                            <option value="B-" <?= (isset($medical_info) && $medical_info['blood_type'] == 'B-') ? 'selected' : '' ?>>B-</option>
                            <option value="AB+" <?= (isset($medical_info) && $medical_info['blood_type'] == 'AB+') ? 'selected' : '' ?>>AB+</option>
                            <option value="AB-" <?= (isset($medical_info) && $medical_info['blood_type'] == 'AB-') ? 'selected' : '' ?>>AB-</option>
                            <option value="O+" <?= (isset($medical_info) && $medical_info['blood_type'] == 'O+') ? 'selected' : '' ?>>O+</option>
                            <option value="O-" <?= (isset($medical_info) && $medical_info['blood_type'] == 'O-') ? 'selected' : '' ?>>O-</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="allergies">Allergies</label>
                        <input type="text" id="allergies" name="allergies" value="<?= isset($medical_info) ? esc($medical_info['allergies']) : '' ?>" placeholder="Known allergies (e.g., Penicillin, Peanuts)">
                    </div>

                    <div class="form-group full-width">
                        <label for="existing_condition">Existing Conditions</label>
                        <textarea id="existing_condition" name="existing_condition" placeholder="Pre-existing medical conditions"><?= isset($medical_info) ? esc($medical_info['existing_condition']) : '' ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="primary_physician">Primary Physician</label>
                        <input type="text" id="primary_physician" name="primary_physician" value="<?= isset($medical_info) ? esc($medical_info['primary_physician']) : '' ?>" placeholder="Dr. Name">
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('patients') ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        <?= isset($patient) ? 'Update Patient' : 'Add Patient' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
