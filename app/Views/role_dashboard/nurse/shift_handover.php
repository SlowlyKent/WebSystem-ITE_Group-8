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

        .handover-section {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .handover-summary {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .summary-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .summary-label {
            font-weight: 600;
            color: #052719;
        }

        .summary-value {
            color: #666;
        }

        .patient-summary {
            margin-top: 20px;
        }

        .patient-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .patient-name {
            color: #052719;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .patient-details {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }

        .shift-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-card {
            background: #e8f5e8;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .info-card h4 {
            color: #052719;
            margin-bottom: 5px;
        }

        .info-card p {
            color: #666;
        }

        @media (max-width: 992px) {
            .dashboard {
                flex-direction: column;
            }
            
            .main {
                width: 100%;
                padding: 15px;
            }

            .shift-info {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
