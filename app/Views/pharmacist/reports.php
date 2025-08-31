<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'Reports') ?></title>
  <link rel="stylesheet" href="<?= base_url('assets/css/pharmacist.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="brand">
      <div class="avatar">📊</div>
      <div class="brand-text">
        <h1>NAME, LOGO</h1>
        <small>Pharmacist Dashboard</small>
      </div>
    </div>
    <nav class="nav">
      <a class="nav-item" href="<?= site_url('pharmacist') ?>">Dashboard</a>
      <a class="nav-item" href="<?= site_url('pharmacist/dispense') ?>">Dispense Medicines</a>
      <a class="nav-item" href="<?= site_url('pharmacist/inventory') ?>">Inventory Management</a>
      <a class="nav-item" href="<?= site_url('pharmacist/alerts') ?>">Low Stock & Expiry Alerts</a>
      <a class="nav-item active" href="#">Reports</a>
      <a class="nav-item" href="<?= site_url('pharmacist/lookup') ?>">Patient Prescription Lookup</a>
    </nav>
    <div class="sidebar-footer">
      <a class="logout" href="<?= site_url('logout') ?>">Log out</a>
    </div>
  </aside>
  <main class="content">
    <header class="topbar">
      <div class="title">Reports</div>
    </header>

    <section class="stats">
      <div class="stat-card"><div class="stat-content"><div class="stat-number"><?= esc($report['dispensed_today'] ?? 0) ?></div><div class="stat-label">Dispensed Today</div></div></div>
      <div class="stat-card"><div class="stat-content"><div class="stat-number"><?= esc($report['dispensed_week'] ?? 0) ?></div><div class="stat-label">Dispensed This Week</div></div></div>
      <div class="stat-card"><div class="stat-content"><div class="stat-number">0</div><div class="stat-label">Returns</div></div></div>
    </section>

    <section class="panel">
      <div class="panel-header"><h3>Top Medicines</h3></div>
      <div class="panel-body">
        <table class="table">
          <thead><tr><th>Medicine</th><th>Qty</th></tr></thead>
          <tbody>
            <?php foreach(($report['top_medicines'] ?? []) as $row): ?>
              <tr><td><?= esc($row['name']) ?></td><td><?= esc($row['qty']) ?></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>
</body>
</html>
