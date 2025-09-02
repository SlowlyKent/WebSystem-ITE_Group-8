<?php
// app/Views/pharmacist/dashboard.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title ?? 'Pharmacist Dashboard') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/pharmacist.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand">
            <div class="avatar">👤</div>
            <div class="brand-text">
                <h1>NAME, LOGO</h1>
                <small>Pharmacist Dashboard</small>
            </div>
        </div>
        <nav class="nav">
            <a class="nav-item active" href="<?= site_url('pharmacist') ?>">Dashboard</a>
            <a class="nav-item" href="<?= site_url('pharmacist/dispense') ?>">Dispense Medicines</a>
            <a class="nav-item" href="<?= site_url('pharmacist/inventory') ?>">Inventory Management</a>
            <a class="nav-item" href="<?= site_url('pharmacist/alerts') ?>">Low Stock & Expiry Alerts</a>
            <a class="nav-item" href="<?= site_url('pharmacist/reports') ?>">Reports</a>
            <a class="nav-item" href="<?= site_url('pharmacist/lookup') ?>">Patient Prescription Lookup</a>
        </nav>
        <div class="sidebar-footer">
            <a class="logout" href="<?= site_url('logout') ?>">Log out</a>
        </div>
    </aside>

    <main class="content">
        <header class="topbar">
            <div class="title">Pharmacist Dashboard</div>
            <button class="icon-btn" aria-label="Notifications">🔔</button>
        </header>

        <section class="stats">
            <div class="stat-card">
                <div class="stat-icon">●</div>
                <div class="stat-content">
                    <div class="stat-number"><?= esc($stats['in_stock'] ?? 0) ?></div>
                    <div class="stat-label">Medicines in Stock</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">●</div>
                <div class="stat-content">
                    <div class="stat-number"><?= esc($stats['low_stock'] ?? 0) ?></div>
                    <div class="stat-label">Low Stock Items</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">●</div>
                <div class="stat-content">
                    <div class="stat-number"><?= esc($stats['expiring_soon'] ?? 0) ?></div>
                    <div class="stat-label">Expiring Soon</div>
                </div>
            </div>
        </section>

        <section class="panels">
            <div class="panel">
                <div class="panel-header">
                    <h3>Pending Prescriptions</h3>
                </div>
                <div class="panel-body">
                    <?php if (!empty($pending_prescriptions)): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Prescription #</th>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending_prescriptions as $p): ?>
                                    <tr>
                                        <td><?= esc($p['id']) ?></td>
                                        <td><?= esc($p['patient']) ?></td>
                                        <td><?= esc($p['date']) ?></td>
                                        <td><?= esc($p['status']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty">No pending prescriptions.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h3>Dispense Medicines</h3>
                </div>
                <div class="panel-body">
                    <form class="form grid" method="post" action="<?= site_url('pharmacist/dispense') ?>">
                        <div class="form-group">
                            <label for="rx">Prescription #</label>
                            <input id="rx" name="rx" type="text" placeholder="Enter prescription ID" />
                        </div>
                        <div class="form-group">
                            <label for="med">Medicine</label>
                            <input id="med" name="med" type="text" placeholder="Search medicine" />
                        </div>
                        <div class="form-group">
                            <label for="qty">Quantity</label>
                            <input id="qty" name="qty" type="number" min="1" value="1" />
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn primary">Dispense</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>
