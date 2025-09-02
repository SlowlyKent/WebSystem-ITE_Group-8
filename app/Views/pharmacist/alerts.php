<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'Alerts') ?></title>
  <link rel="stylesheet" href="<?= base_url('assets/css/pharmacist.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="brand">
      <div class="avatar">⚠️</div>
      <div class="brand-text">
        <h1>NAME, LOGO</h1>
        <small>Pharmacist Dashboard</small>
      </div>
    </div>
    <nav class="nav">
      <a class="nav-item" href="<?= site_url('pharmacist') ?>">Dashboard</a>
      <a class="nav-item" href="<?= site_url('pharmacist/dispense') ?>">Dispense Medicines</a>
      <a class="nav-item" href="<?= site_url('pharmacist/inventory') ?>">Inventory Management</a>
      <a class="nav-item active" href="#">Low Stock & Expiry Alerts</a>
      <a class="nav-item" href="<?= site_url('pharmacist/reports') ?>">Reports</a>
      <a class="nav-item" href="<?= site_url('pharmacist/lookup') ?>">Patient Prescription Lookup</a>
    </nav>
    <div class="sidebar-footer">
      <a class="logout" href="<?= site_url('logout') ?>">Log out</a>
    </div>
  </aside>
  <main class="content">
    <header class="topbar">
      <div class="title">Low Stock & Expiry Alerts</div>
    </header>

    <section class="panels">
      <div class="panel">
        <div class="panel-header"><h3>Medicines Low in Stock</h3></div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr><th>Name</th><th>Stock</th></tr>
            </thead>
            <tbody>
              <?php foreach(($lowStock ?? []) as $row): ?>
                <tr><td><?= esc($row['name']) ?></td><td><?= esc($row['stock']) ?></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="panel">
        <div class="panel-header"><h3>Near Expiration</h3></div>
        <div class="panel-body">
          <table class="table">
            <thead>
              <tr><th>Name</th><th>Expires</th></tr>
            </thead>
            <tbody>
              <?php foreach(($expiring ?? []) as $row): ?>
                <tr><td><?= esc($row['name']) ?></td><td><?= esc($row['expires']) ?></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </main>
</div>
</body>
</html>
