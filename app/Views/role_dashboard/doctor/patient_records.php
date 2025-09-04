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
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-primary {
            background-color: #14524a;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0f3d37;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .patient-table-container {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .patient-table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-table thead {
            background-color: #052719;
            color: white;
        }

        .patient-table th,
        .patient-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .patient-table th {
            font-weight: bold;
            font-size: 14px;
        }

        .patient-table td {
            font-size: 13px;
        }

        .patient-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-discharged {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-admitted {
            background-color: #fff3cd;
            color: #856404;
        }

        .no-patients {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .no-patients i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-input {
            width: 300px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .patient-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .patient-avatar {
            width: 32px;
            height: 32px;
            background-color: #052719;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <?= $this->include('role_dashboard/doctor/_doctor_sidebar') ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-user-injured"></i> Patient Records</h1>
            <a href="<?= base_url('doctor/dashboard') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Return to Dashboard
            </a>
        </div>

        <!-- Search Container -->
        <div class="search-container">
            <input type="text" id="patientSearch" class="search-input" placeholder="Search patients by name, email, or phone...">
        </div>

        <!-- Patient Table -->
        <div class="patient-table-container">
            <?php if (!empty($patients)): ?>
                <table class="patient-table" id="patientTable">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Gender</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Room</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td>
                                    <div class="patient-info">
                                        <div class="patient-avatar">
                                            <?= strtoupper(substr($patient['first_name'], 0, 1) . substr($patient['last_name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <strong><?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?></strong>
                                            <br>
                                            <small style="color: #6c757d;">ID: <?= esc($patient['id']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?= esc($patient['gender'] ?? 'N/A') ?>
                                </td>
                                <td>
                                    <?= esc($patient['phone'] ?? 'N/A') ?><br>
                                    <small style="color: #6c757d;"><?= esc($patient['email'] ?? 'N/A') ?></small>
                                </td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($patient['status'] ?? 'active') ?>">
                                        <?= esc($patient['status'] ?? 'Active') ?>
                                    </span>
                                </td>
                                <td><?= esc($patient['room'] ?? 'N/A') ?></td>
                                <td>
                                    <?php 
                                    $updatedAt = $patient['updated_at'] ?? $patient['created_at'] ?? '';
                                    if ($updatedAt) {
                                        $date = new DateTime($updatedAt);
                                        echo $date->format('M d, Y');
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('doctor/patient/' . $patient['id']) ?>" class="btn btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-patients">
                    <i class="fas fa-user-injured"></i>
                    <h3>No Patients Found</h3>
                    <p>No patient records are currently available in the database.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('patientSearch').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('patientTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;

                // Search in patient name, contact info
                for (let j = 0; j < 3; j++) {
                    if (cells[j] && cells[j].textContent.toLowerCase().includes(searchValue)) {
                        found = true;
                        break;
                    }
                }

                row.style.display = found ? '' : 'none';
            }
        });
    </script>
</body>
</html>
