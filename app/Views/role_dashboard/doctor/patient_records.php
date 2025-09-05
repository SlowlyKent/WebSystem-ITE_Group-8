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

        .page-header {
            background: #81c798;
            height: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 10px rgba(0,0,0,.2);
            display: flex;
            align-items: center;
            padding: 0 20px;
            color: #052719;
            font-weight: bold;
            gap: 10px;
            margin-bottom: 20px;
        }

        .page-header h1 {
            font-size: 18px;
            margin: 0;
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
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 6px rgba(0,0,0,.1);
        }

        .patient-table thead {
            background: #559680;
            color: white;
        }

        .patient-table th,
        .patient-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .patient-table th {
            font-weight: 600;
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

        .search-bar {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 10px 12px;
            border-radius: 20px;
            box-shadow: 0 3px 6px rgba(0,0,0,.1);
            gap: 10px;
            margin-top: 10px;
            width: 100%;
        }

        .search-bar input {
            border: none;
            outline: none;
            flex: 1;
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

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main {
                padding: 20px 20px 20px 320px;
            }
        }

        @media (max-width: 992px) {
            .dashboard {
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
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar Navigation -->
        <?= $this->include('role_dashboard/doctor/_doctor_sidebar') ?>

        <!-- Main Content -->
        <main class="main">
        <div class="page-header">
            <h1><i class="fas fa-user"></i> Patient Records</h1>
        </div>

        <!-- Search Container -->
        <div class="search-container">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" id="patientSearch" placeholder="Search patients by name, email, or phone...">
            </div>
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
        </main>
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
