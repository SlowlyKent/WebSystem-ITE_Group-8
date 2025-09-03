<?php include __DIR__.'/_layout_parts.php'; ?>
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-pills"></i></div>
                <div class="stat-info">
                    <h3><?= (int)($pharmaStats['medicinesInStock'] ?? 0) ?></h3>
                    <p>Medicines in Stock</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-arrow-down"></i></div>
                <div class="stat-info">
                    <h3><?= (int)($pharmaStats['lowStockItems'] ?? 0) ?></h3>
                    <p>Low Stock Items</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-info">
                    <h3><?= (int)($pharmaStats['expiringSoon'] ?? 0) ?></h3>
                    <p>Expiring Soon</p>
                </div>
            </div>
        </div>
        <div class="grid-2">
            <div class="card">
                <h2><i class="fas fa-file-prescription"></i> Pending Prescriptions</h2>
                <div class="placeholder">No pending prescriptions yet.</div>
            </div>
            <div class="card">
                <h2><i class="fas fa-prescription-bottle"></i> Dispense Medicines</h2>
                <div class="actions">
                    <a class="btn" href="<?= base_url('pharmacy/dispense') ?>"><i class="fas fa-play"></i> Start Dispense</a>
                    <a class="btn secondary" href="<?= base_url('pharmacy/inventory') ?>"><i class="fas fa-boxes-stacked"></i> View Inventory</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
