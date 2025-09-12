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
            position: sticky;
            top: 20px;
            z-index: 100;
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

        .patients-section {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .patient-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .patient-info h4 {
            color: #052719;
            margin-bottom: 5px;
        }

        .patient-info p {
            color: #666;
            font-size: 14px;
            margin: 2px 0;
        }

        .patient-status {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-stable {
            background: #d4edda;
            color: #155724;
        }

        .status-critical {
            background: #f8d7da;
            color: #721c24;
        }

        .status-recovery {
            background: #fff3cd;
            color: #856404;
        }

        .no-patients {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .dashboard {
                flex-direction: column;
            }
            
            .main {
                width: 100%;
                padding: 15px;
            }

            .patient-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
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
                    <h1>Patient Assignments</h1>
                    <p>Your assigned patients for today</p>
                </div>
            </header>

            <div class="patients-section">
                <h3><i class="fas fa-user-injured"></i> Today's Assigned Patients</h3>
                
                <!-- Sample patients - replace with dynamic data -->
                <div class="patient-card">
                    <div class="patient-info">
                        <h4>John Smith</h4>
                        <p>Room: 101A | Age: 45 | Admitted: 2024-01-15</p>
                        <p>Condition: Post-operative care</p>
                    </div>
                    <span class="patient-status status-stable">Stable</span>
                </div>

                <div class="patient-card">
                    <div class="patient-info">
                        <h4>Mary Johnson</h4>
                        <p>Room: 102B | Age: 67 | Admitted: 2024-01-14</p>
                        <p>Condition: Diabetes management</p>
                    </div>
                    <span class="patient-status status-recovery">Recovery</span>
                </div>

                <div class="patient-card">
                    <div class="patient-info">
                        <h4>Robert Brown</h4>
                        <p>Room: 103A | Age: 52 | Admitted: 2024-01-16</p>
                        <p>Condition: Cardiac monitoring</p>
                    </div>
                    <span class="patient-status status-critical">Critical</span>
                </div>

                <!-- Uncomment when no patients -->
                <!-- <div class="no-patients">
                    <i class="fas fa-user-injured" style="font-size: 48px; color: #ccc; margin-bottom: 15px;"></i>
                    <p>No patients assigned today</p>
                </div> -->
            </div>
        </main>
    </div>
</body>
</html>
