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

        .medication-section {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .med-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .med-info h4 {
            color: #052719;
            margin-bottom: 5px;
        }

        .med-info p {
            color: #666;
            font-size: 14px;
            margin: 2px 0;
        }

        .med-time {
            background: #fff3cd;
            color: #856404;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .med-time.overdue {
            background: #f8d7da;
            color: #721c24;
        }

        .med-time.completed {
            background: #d4edda;
            color: #155724;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-container input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .checkbox-container label {
            cursor: pointer;
            font-weight: 600;
            color: #052719;
        }

        @media (max-width: 992px) {
            .dashboard {
                flex-direction: column;
            }
            
            .main {
                width: 100%;
                padding: 15px;
            }

            .med-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
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
                    <h1>Medication Administration</h1>
                    <p>Track and administer patient medications</p>
                </div>
            </header>

            <div class="medication-section">
                <h3><i class="fas fa-pills"></i> Scheduled Medications</h3>
                
                <div class="med-item">
                    <div class="med-info">
                        <h4>John Smith - Room 101A</h4>
                        <p>Medication: Metformin 500mg</p>
                        <p>Dosage: 1 tablet, twice daily</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span class="med-time">08:00 AM</span>
                        <div class="checkbox-container">
                            <input type="checkbox" id="med1" name="med1">
                            <label for="med1">Given</label>
                        </div>
                    </div>
                </div>

                <div class="med-item">
                    <div class="med-info">
                        <h4>Mary Johnson - Room 102B</h4>
                        <p>Medication: Lisinopril 10mg</p>
                        <p>Dosage: 1 tablet, once daily</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span class="med-time overdue">07:30 AM</span>
                        <div class="checkbox-container">
                            <input type="checkbox" id="med2" name="med2">
                            <label for="med2">Given</label>
                        </div>
                    </div>
                </div>

                <div class="med-item">
                    <div class="med-info">
                        <h4>Robert Brown - Room 103A</h4>
                        <p>Medication: Aspirin 81mg</p>
                        <p>Dosage: 1 tablet, once daily</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span class="med-time completed">06:00 AM</span>
                        <div class="checkbox-container">
                            <input type="checkbox" id="med3" name="med3" checked disabled>
                            <label for="med3">Given</label>
                        </div>
                    </div>
                </div>

                <div class="med-item">
                    <div class="med-info">
                        <h4>John Smith - Room 101A</h4>
                        <p>Medication: Metformin 500mg</p>
                        <p>Dosage: 1 tablet, twice daily</p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span class="med-time">06:00 PM</span>
                        <div class="checkbox-container">
                            <input type="checkbox" id="med4" name="med4">
                            <label for="med4">Given</label>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Simple checkbox handling
        document.querySelectorAll('input[type="checkbox"]:not([disabled])').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    const timeSpan = this.closest('.med-item').querySelector('.med-time');
                    timeSpan.className = 'med-time completed';
                    timeSpan.textContent = 'Completed';
                    this.disabled = true;
                }
            });
        });
    </script>
</body>
</html>
