<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'Dispense Medicines') ?></title>
  <link rel="stylesheet" href="<?= base_url('assets/css/pharmacist.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="brand">
      <div class="avatar">💉</div>
      <div class="brand-text">
        <h1>NAME, LOGO</h1>
        <small>Pharmacist Dashboard</small>
      </div>
    </div>
    <nav class="nav">
      <a class="nav-item" href="<?= site_url('pharmacist') ?>">Dashboard</a>
      <a class="nav-item active" href="#">Dispense Medicines</a>
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
      <div class="title">Dispense Medicines</div>
    </header>

    <?php if (!empty($message)): ?>
      <section class="panel"><div class="panel-body"><?= esc($message) ?></div></section>
    <?php endif; ?>

    <section class="panel">
      <div class="panel-header"><h3>Dispense Form</h3></div>
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
    </section>
  </main>
</div>
</body>
</html>
