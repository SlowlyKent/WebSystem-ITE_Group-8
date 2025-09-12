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

        .notes-section {
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

        .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
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

        .recent-notes {
            margin-top: 30px;
        }

        .note-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .note-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .note-patient {
            color: #052719;
            font-weight: 600;
        }

        .note-time {
            color: #666;
            font-size: 12px;
        }

        .note-content {
            color: #333;
            line-height: 1.5;
        }

        @media (max-width: 992px) {
            .dashboard {
                flex-direction: column;
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
        <?= $this->include('role_dashboard/nurse/_nurse_sidebar') ?>

        <main class="main">
            <header class="main-header">
                <div class="header-left">
                    <h1>Nursing Notes</h1>
                    <p>Document patient care and observations</p>
                </div>
            </header>

            <div class="notes-section">
                <h3><i class="fas fa-clipboard-list"></i> Add New Note</h3>
                
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

                    <div class="form-group">
                        <label for="note">Nursing Note</label>
                        <textarea id="note" name="note" placeholder="Enter your observations, care provided, patient response, etc..." required></textarea>
                    </div>

                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i> Save Note
                    </button>
                </form>

                <div class="recent-notes">
                    <h3><i class="fas fa-history"></i> Recent Notes</h3>
                    
                    <div class="note-item">
                        <div class="note-header">
                            <span class="note-patient">John Smith - Room 101A</span>
                            <span class="note-time">Today, 2:30 PM</span>
                        </div>
                        <div class="note-content">
                            Patient ambulated in hallway for 15 minutes with assistance. Vital signs stable. No complaints of pain. Appetite good, ate 75% of lunch.
                        </div>
                    </div>

                    <div class="note-item">
                        <div class="note-header">
                            <span class="note-patient">Mary Johnson - Room 102B</span>
                            <span class="note-time">Today, 1:15 PM</span>
                        </div>
                        <div class="note-content">
                            Blood glucose checked - 145 mg/dL. Insulin administered as ordered. Patient educated on dietary choices. Understanding demonstrated.
                        </div>
                    </div>

                    <div class="note-item">
                        <div class="note-header">
                            <span class="note-patient">Robert Brown - Room 103A</span>
                            <span class="note-time">Today, 12:45 PM</span>
                        </div>
                        <div class="note-content">
                            Cardiac monitor shows normal sinus rhythm. Patient reports chest discomfort 2/10. Nitroglycerin given as needed. Will continue monitoring.
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
