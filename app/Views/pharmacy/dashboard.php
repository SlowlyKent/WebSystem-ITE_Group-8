<?php /** @var array $stats */ /** @var array $user */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacist Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary:#052719; --bg:#b9d3c9; --card:#ffffff; --muted:#6c757d; }
        *{box-sizing:border-box}
        body{background:var(--bg);margin:0;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;color:#222}
        .layout{display:flex;gap:16px;padding:16px}
        .sidebar{width:260px;background:#eee;border-radius:14px;padding:16px}
        .brand{display:flex;align-items:center;gap:10px;background:var(--card);border-radius:12px;padding:14px;margin-bottom:14px;border:1px solid #ddd}
        .brand-title{font-weight:700;color:var(--primary)}
        .avatar{width:90px;height:90px;border-radius:50%;background:#ddd;display:grid;place-items:center;margin:10px auto}
        .avatar i{font-size:42px;color:#666}
        .role{display:block;width:100%;text-align:center;background:var(--primary);color:#fff;border:none;border-radius:10px;padding:10px;margin:8px 0}
        .nav{margin-top:10px}
        .nav a{display:flex;align-items:center;gap:10px;padding:10px 12px;color:#333;text-decoration:none;border-radius:10px}
        .nav a:hover,.nav a.active{background:#e5efea;color:var(--primary)}
        .logout{margin-top:14px;display:flex;gap:8px;align-items:center;justify-content:center;background:#333;color:#fff;border:none;border-radius:10px;padding:10px;text-decoration:none}
        .content{flex:1}
        .top{background:var(--card);border-radius:14px;height:44px;border:1px solid #ddd;display:flex;align-items:center;justify-content:flex-end;padding:0 12px}
        .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin:16px 0}
        .card{background:var(--card);border-radius:14px;padding:16px;border:1px solid #ddd}
        .stat{display:flex;align-items:center;gap:12px}
        .stat .dot{width:34px;height:34px;border-radius:50%;background:#e6f0ec;display:grid;place-items:center;color:var(--primary)}
        .panels{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        h3{margin:0 0 6px 0;color:#333}
        .muted{color:var(--muted);font-size:12px}
        @media(max-width:900px){.layout{flex-direction:column}.sidebar{width:100%}.grid{grid-template-columns:1fr}.panels{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <div class="brand"><i class="fas fa-capsules"></i><span class="brand-title">PHARMACIST DASHBOARD</span></div>
        <div class="avatar"><i class="fas fa-user"></i></div>
        <button class="role">Pharmacist Dashboard</button>
        <nav class="nav">
            <a class="active" href="<?= base_url('pharmacy') ?>"><i class="fas fa-gauge"></i> Dashboard</a>
            <a href="<?= base_url('pharmacy/dispense') ?>"><i class="fas fa-prescription-bottle"></i> Dispense Medicines</a>
            <a href="<?= base_url('inventory') ?>"><i class="fas fa-boxes-stacked"></i> Inventory Management</a>
            <a href="<?= base_url('inventory/low-stock') ?>"><i class="fas fa-triangle-exclamation"></i> Low Stock & Expiry Alerts</a>
            <a href="<?= base_url('pharmacy/reports') ?>"><i class="fas fa-file-waveform"></i> Reports</a>
            <a href="<?= base_url('pharmacy/lookup') ?>"><i class="fas fa-magnifying-glass"></i> Patient Prescription Lookup</a>
        </nav>
        <a class="logout" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i>Log-out</a>
    </aside>
    <main class="content">
        <div class="top"><i class="fas fa-bell"></i></div>
        <section class="grid">
            <div class="card">
                <div class="stat">
                    <div class="dot"><i class="fas fa-pills"></i></div>
                    <div>
                        <h3><?= esc($stats['medicinesInStock']) ?></h3>
                        <div class="muted">Medicines in Stock</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="stat">
                    <div class="dot"><i class="fas fa-arrow-down-wide-short"></i></div>
                    <div>
                        <h3><?= esc($stats['lowStockItems']) ?></h3>
                        <div class="muted">Low Stock Items</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="stat">
                    <div class="dot"><i class="fas fa-hourglass-half"></i></div>
                    <div>
                        <h3><?= esc($stats['expiringSoon']) ?></h3>
                        <div class="muted">Expiring Soon</div>
                    </div>
                </div>
            </div>
        </section>
        <section class="panels">
            <div class="card" style="min-height:220px">
                <h3>Pending Prescriptions</h3>
            </div>
            <div class="card" style="min-height:220px">
                <h3>Dispense Medicines</h3>
            </div>
        </section>
    </main>
</div>
</body>
</html>
