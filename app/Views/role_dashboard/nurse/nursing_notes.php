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
