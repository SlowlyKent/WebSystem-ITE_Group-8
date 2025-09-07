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

        .vitals-form {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #052719;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn {
            background: #052719;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }

        .btn:hover {
            background: #0f6b45;
        }

        @media (max-width: 992px) {
            .dashboard {
                flex-direction: column;
            }
            
            .main {
                width: 100%;
                padding: 15px;
            }

            .form-row {
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
                    <h1>Vital Signs Recording</h1>
                    <p>Record patient vital signs</p>
                </div>
            </header>

            <div class="vitals-form">
                <h3><i class="fas fa-heartbeat"></i> Record Vital Signs</h3>
                
                <form>
                    <div class="form-group">
                        <label for="patient">Select Patient</label>
                        <select id="patient" name="patient" required>
                            <option value="">Choose a patient...</option>
                            <option value="1">John Smith - Room 101A</option>
                            <option value="2">Mary Johnson - Room 102B</option>
                            <option value="3">Robert Brown - Room 103A</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="temperature">Temperature (°F)</label>
                            <input type="number" id="temperature" name="temperature" step="0.1" placeholder="98.6">
                        </div>
                        <div class="form-group">
                            <label for="pulse">Pulse (bpm)</label>
                            <input type="number" id="pulse" name="pulse" placeholder="72">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="bp_systolic">Blood Pressure - Systolic</label>
                            <input type="number" id="bp_systolic" name="bp_systolic" placeholder="120">
                        </div>
                        <div class="form-group">
                            <label for="bp_diastolic">Blood Pressure - Diastolic</label>
                            <input type="number" id="bp_diastolic" name="bp_diastolic" placeholder="80">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="respiratory">Respiratory Rate</label>
                            <input type="number" id="respiratory" name="respiratory" placeholder="16">
                        </div>
                        <div class="form-group">
                            <label for="oxygen">Oxygen Saturation (%)</label>
                            <input type="number" id="oxygen" name="oxygen" placeholder="98">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <input type="text" id="notes" name="notes" placeholder="Additional observations...">
                    </div>

                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i> Record Vital Signs
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
