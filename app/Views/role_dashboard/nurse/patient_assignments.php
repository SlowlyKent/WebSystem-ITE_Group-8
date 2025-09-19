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
