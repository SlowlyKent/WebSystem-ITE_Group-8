<?php
// Reusable CSS and sidebar/menu for Pharmacy pages to keep uniform styling
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - HMS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #b9d3c9; overflow-x: hidden; }
        .sidebar { width: 270px; background-color: #052719; color: white; padding: 15px; border-radius: 15px; margin: 15px; height: calc(100vh - 30px); position: fixed; left: 0; top: 0; z-index: 1000; }
        .sidebar-header { text-align: center; margin-bottom: 25px; }
        .sidebar-header h4 { font-size: 16px; margin-bottom: 15px; font-weight: bold; }
        .user-avatar { width: 50px; height: 50px; background-color: #ccc; border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #666; }
        .sidebar-header p { font-size: 12px; margin-bottom: 5px; }
        .sidebar-header small { font-size: 10px; opacity: 0.8; }
        .nav-menu ul { list-style: none; }
        .nav-menu li { margin-bottom: 3px; }
        .nav-menu a { color: white; text-decoration: none; display: flex; align-items: center; padding: 8px 12px; border-radius: 6px; transition: background-color 0.3s; font-size: 12px; }
        .nav-menu a:hover { background-color: rgba(255,255,255,0.1); }
        .nav-menu a.active { background-color: rgba(255,255,255,0.2); }
        .nav-menu i { margin-right: 8px; width: 14px; font-size: 12px; }
        .logout-section { position: absolute; bottom: 15px; left: 15px; right: 15px; }
        .logout-section a { color: white; text-decoration: none; display: flex; align-items: center; justify-content: center; padding: 8px; border: 1px solid white; border-radius: 6px; transition: background-color 0.3s; font-size: 12px; }
        .logout-section a:hover { background-color: rgba(255,255,255,0.1); }
        .main-content { margin-left: 300px; padding: 20px; min-height: 100vh; }
        .main-header { background-color: #052719; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .header-left h1 { color: white; font-size: 28px; margin-bottom: 5px; }
        .header-left p { color: #ccc; font-size: 16px; }
        .stats-section { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px; }
        .stat-card { background-color: #052719; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-icon { font-size: 20px; color: white; margin-bottom: 8px; }
        .stat-info h3 { font-size: 20px; color: white; margin-bottom: 3px; }
        .stat-info p { color: #ccc; font-size: 12px; }
        .card { background-color: #052719; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card h2 { color: white; margin-bottom: 12px; font-size: 16px; }
        .placeholder { text-align: center; padding: 20px; color: #ccc; background-color: rgba(255,255,255,0.1); border-radius: 6px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .table { width: 100%; border-collapse: collapse; background-color: rgba(255,255,255,0.05); border-radius: 6px; overflow: hidden; color: #fff; font-size: 12px; }
        .table th, .table td { padding: 10px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .table th { text-align: left; color: #ddd; }
        .btn { display: inline-flex; align-items: center; gap: 6px; background: #0a3d26; color: #fff; border: none; padding: 8px 10px; border-radius: 6px; cursor: pointer; font-size: 12px; text-decoration: none; }
        .btn.secondary { background: transparent; border: 1px solid rgba(255,255,255,0.2); }
        .btn:hover { background: #0f5335; }
        .actions { display: flex; gap: 8px; flex-wrap: wrap; }
        .search-bar { display: flex; gap: 8px; margin-bottom: 12px; }
        .search-bar input { flex: 1; padding: 8px 10px; border-radius: 6px; border: 1px solid #e9ecef; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 11px; }
        .badge.warn { background: #b58100; color: #fff; }
        .badge.danger { background: #a31d1d; color: #fff; }
        .menu-badge { margin-left: 6px; background:#b58100; color:#fff; border-radius:999px; padding:0 6px; font-size:10px; line-height:16px; display:inline-block; min-width:16px; text-align:center; }
        .notice-bar { background: linear-gradient(135deg, rgba(181,129,0,0.25), rgba(10,61,38,0.35)); border:1px solid rgba(255,255,255,0.18); color:#fff; border-radius:10px; padding:12px 14px; display:flex; gap:14px; align-items:center; box-shadow: 0 4px 14px rgba(0,0,0,0.1); }
        .notice-icon { width:30px; height:30px; border-radius:50%; background: rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; }
        .notice-title { font-weight:600; letter-spacing: .2px; }
        .notice-bar a { color:#fff; text-decoration:none; background:#0a3d26; border:1px solid rgba(255,255,255,0.2); padding:6px 10px; border-radius:6px; }
        .notice-bar a:hover { background:#0f5335; }
        .notice-pill { display:inline-flex; align-items:center; gap:6px; padding:4px 10px; border-radius:999px; font-size:12px; border:1px solid rgba(255,255,255,0.15); }
        .pill-low { background: rgba(163,29,29,0.25); }
        .pill-exp { background: rgba(181,129,0,0.25); }
        .pill-expd { background: rgba(163,29,29,0.35); }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>HMS</h4>
            <div class="user-avatar"><i class="fas fa-user"></i></div>
            <p><?= esc($user['fullName'] ?? '') ?></p>
            <small>Pharmacist Dashboard</small>
        </div>
        <nav class="nav-menu">
            <ul>
                <li><a class="<?= (url_is('pharmacy') || url_is('pharmacy/')) ? 'active' : '' ?>" href="<?= base_url('pharmacy') ?>"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a class="<?= url_is('pharmacy/dispense') ? 'active' : '' ?>" href="<?= base_url('pharmacy/dispense') ?>"><i class="fas fa-prescription-bottle"></i>Dispense Medicines</a></li>
                <li><a class="<?= url_is('pharmacy/inventory') ? 'active' : '' ?>" href="<?= base_url('pharmacy/inventory') ?>"><i class="fas fa-boxes-stacked"></i>Inventory Management</a></li>
                <li><a class="<?= url_is('pharmacy/receive') ? 'active' : '' ?>" href="<?= base_url('pharmacy/receive') ?>"><i class="fas fa-truck-loading"></i>Receive Stock</a></li>
                <li>
                    <a class="<?= url_is('pharmacy/alerts') ? 'active' : '' ?>" href="<?= base_url('pharmacy/alerts') ?>">
                        <i class="fas fa-bell"></i>Low Stock & Expiry Alerts
                        <?php $alertsTotal = (int)($pharmaStats['alertsTotal'] ?? 0); if ($alertsTotal > 0): ?>
                            <span class="menu-badge"><?= $alertsTotal ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li><a class="<?= url_is('pharmacy/reports') ? 'active' : '' ?>" href="<?= base_url('pharmacy/reports') ?>"><i class="fas fa-chart-bar"></i>Reports</a></li>
                <li><a class="<?= url_is('pharmacy/lookup') || url_is('pharmacy/lookup/*') ? 'active' : '' ?>" href="<?= base_url('pharmacy/lookup') ?>"><i class="fas fa-file-medical"></i>Patient Prescription Lookup</a></li>
            </ul>
        </nav>
        <div class="logout-section">
            <a href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i>Log-out</a>
        </div>
    </div>
    <div class="main-content">
        <header class="main-header">
            <div class="header-left">
                <h1><?= esc($title) ?></h1>
                <p>Welcome, <?= esc($user['fullName'] ?? '') ?></p>
            </div>
            <div></div>
        </header>
        <?php
            $lowCnt = (int)($pharmaStats['lowStockItems'] ?? 0);
            $expCnt = (int)($pharmaStats['expiringSoon'] ?? 0);
            $expdCnt = (int)($pharmaStats['expired'] ?? 0);
            $totalAlerts = $lowCnt + $expCnt + $expdCnt;
        ?>
        <?php if ($totalAlerts > 0): ?>
            <div class="notice-bar" style="margin-bottom:12px;">
                <div class="notice-icon"><i class="fas fa-bell"></i></div>
                <div class="notice-title">Inventory Alerts</div>
                <span class="notice-pill pill-low"><i class="fas fa-arrow-down"></i> Low: <?= $lowCnt ?></span>
                <span class="notice-pill pill-exp"><i class="fas fa-hourglass-half"></i> Expiring: <?= $expCnt ?></span>
                <span class="notice-pill pill-expd"><i class="fas fa-triangle-exclamation"></i> Expired: <?= $expdCnt ?></span>
                <span style="flex:1"></span>
                <a href="<?= base_url('pharmacy/alerts') ?>"><i class="fas fa-eye"></i> View details</a>
            </div>
        <?php endif; ?>
