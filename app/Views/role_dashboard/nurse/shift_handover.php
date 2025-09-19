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
        <?= $this->include('role_dashboard/nurse/_nurse_sidebar') ?>

        <main class="main">
            <header class="main-header">
                <div class="header-left">
                    <h1>Shift Handover</h1>
                    <p>End of shift summary and patient handover</p>
                </div>
            </header>

            <div class="handover-section">
                <div class="shift-info">
                    <div class="info-card">
                        <h4>Current Shift</h4>
                        <p>Day Shift: 7:00 AM - 7:00 PM</p>
                    </div>
                    <div class="info-card">
                        <h4>Next Shift</h4>
                        <p>Night Shift: 7:00 PM - 7:00 AM</p>
                    </div>
                </div>

                <div class="handover-summary">
                    <h3><i class="fas fa-clipboard-check"></i> Shift Summary</h3>
                    <div class="summary-item">
                        <span class="summary-label">Total Patients:</span>
                        <span class="summary-value">3</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Medications Given:</span>
                        <span class="summary-value">8 of 9 scheduled</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Vital Signs Recorded:</span>
                        <span class="summary-value">All patients completed</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Incidents:</span>
                        <span class="summary-value">None reported</span>
                    </div>
                </div>

                <div class="patient-summary">
                    <h3><i class="fas fa-users"></i> Patient Handover</h3>
                    
                    <div class="patient-card">
                        <div class="patient-name">John Smith - Room 101A</div>
                        <div class="patient-details">
                            <strong>Condition:</strong> Post-operative, stable<br>
                            <strong>Last Vitals:</strong> T: 98.6°F, BP: 120/80, HR: 72<br>
                            <strong>Medications:</strong> All given on schedule<br>
                            <strong>Notes:</strong> Ambulated 15 min, good appetite, no pain complaints
                        </div>
                    </div>

                    <div class="patient-card">
                        <div class="patient-name">Mary Johnson - Room 102B</div>
                        <div class="patient-details">
                            <strong>Condition:</strong> Diabetes management, stable<br>
                            <strong>Last Vitals:</strong> T: 98.2°F, BP: 130/85, HR: 78<br>
                            <strong>Blood Glucose:</strong> 145 mg/dL at 1:00 PM<br>
                            <strong>Notes:</strong> Insulin given, dietary education provided
                        </div>
                    </div>

                    <div class="patient-card">
                        <div class="patient-name">Robert Brown - Room 103A</div>
                        <div class="patient-details">
                            <strong>Condition:</strong> Cardiac monitoring, requires attention<br>
                            <strong>Last Vitals:</strong> T: 99.1°F, BP: 140/90, HR: 88<br>
                            <strong>Medications:</strong> Lisinopril missed - patient refused<br>
                            <strong>Notes:</strong> Chest discomfort 2/10, nitroglycerin given PRN
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
