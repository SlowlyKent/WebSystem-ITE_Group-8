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
