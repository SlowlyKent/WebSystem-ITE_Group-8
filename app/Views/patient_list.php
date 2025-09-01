<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient List - HMS</title>
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
            color: white;
        }

        .sidebar-header small {
            font-size: 10px;
            opacity: 0.8;
            color: white;
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
        }

        .page-header h1 {
            color: white;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .add-patient-btn {
            background-color: #b9d3c9;
            color: #052719;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .add-patient-btn:hover {
            background-color: #a8d5ba;
        }

        /* Patient Table */
        .patient-table-container {
            background-color: #052719;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .patient-table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-table th {
            background-color: #052719;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 14px;
            font-weight: bold;
        }

        .patient-table td {
            padding: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 14px;
            color: white;
        }

        .patient-table tr:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .action-btn {
            padding: 5px 10px;
            margin-right: 5px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            transition: background-color 0.3s;
        }

        .edit-btn {
            background-color: #28a745;
            color: white;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .view-btn {
            background-color: #17a2b8;
            color: white;
        }

        .view-btn:hover {
            background-color: #138496;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #ccc;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #ccc;
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
            <h1>Patient List</h1>
            <a href="<?= base_url('patients/create') ?>" class="add-patient-btn">
                <i class="fas fa-plus"></i> Add New Patient
            </a>
        </div>

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
    </div>
</body>
</html>
