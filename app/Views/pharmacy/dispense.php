<?php include __DIR__.'/_layout_parts.php'; ?>
        <div class="card">
            <h2><i class="fas fa-prescription-bottle"></i> Dispense Medicines</h2>
            <div class="search-bar">
                <input type="text" placeholder="Search patient or prescription no.">
                <a class="btn" href="#"><i class="fas fa-search"></i> Search</a>
            </div>
            <div class="grid-2">
                <div class="card">
                    <h2><i class="fas fa-file-medical"></i> Prescription</h2>
                    <div class="placeholder">Select a prescription to view items.</div>
                </div>
                <div class="card">
                    <h2><i class="fas fa-cash-register"></i> Dispense Summary</h2>
                    <div class="placeholder">No items selected.</div>
                    <div class="actions" style="margin-top:12px;">
                        <a class="btn" href="#"><i class="fas fa-check"></i> Confirm Dispense</a>
                        <a class="btn secondary" href="#"><i class="fas fa-times"></i> Clear</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
