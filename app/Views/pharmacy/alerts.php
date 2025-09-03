<?php include __DIR__.'/_layout_parts.php'; ?>
        <div class="card">
            <h2 style="display:flex; align-items:center; gap:8px;">
                <i class="fas fa-bell"></i> Low Stock & Expiry Alerts
            </h2>

            <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:16px; margin-top:12px;">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-arrow-down"></i></div>
                    <div class="stat-info">
                        <h3><?= esc($counts['low'] ?? 0) ?></h3>
                        <p>Low Stock</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="stat-info">
                        <h3><?= esc($counts['expiring'] ?? 0) ?></h3>
                        <p>Expiring (≤30 days)</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-triangle-exclamation"></i></div>
                    <div class="stat-info">
                        <h3><?= esc($counts['expired'] ?? 0) ?></h3>
                        <p>Expired</p>
                    </div>
                </div>
            </div>

            <div class="section" style="margin-top:18px;">
                <div class="section-title" style="color:#fff; font-size:14px; margin-bottom:8px; display:flex; align-items:center; gap:6px;"><i class="fas fa-arrow-down"></i> Low Stock</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Generic</th>
                            <th>Qty</th>
                            <th>Reorder</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($low)): ?>
                            <?php foreach ($low as $m): ?>
                                <tr>
                                    <td><?= esc($m['name'] ?? '') ?></td>
                                    <td><?= esc($m['generic_name'] ?? '') ?></td>
                                    <td><?= esc($m['quantity'] ?? 0) ?></td>
                                    <td><?= esc($m['reorder_level'] ?? 0) ?></td>
                                    <td><span class="badge danger">Low</span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="placeholder">No low stock items.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="section" style="margin-top:18px;">
                <div class="section-title" style="color:#fff; font-size:14px; margin-bottom:8px; display:flex; align-items:center; gap:6px;"><i class="fas fa-hourglass-half"></i> Expiring (≤30 days)</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Generic</th>
                            <th>Batch</th>
                            <th>Expiry</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($expiring)): ?>
                            <?php foreach ($expiring as $m): ?>
                                <tr>
                                    <td><?= esc($m['name'] ?? '') ?></td>
                                    <td><?= esc($m['generic_name'] ?? '') ?></td>
                                    <td><?= esc($m['batch_no'] ?? '') ?></td>
                                    <td><?= !empty($m['expiry_date']) ? esc(date('Y-m-d', strtotime($m['expiry_date']))) : '—' ?></td>
                                    <td><span class="badge warn">Expiring</span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="placeholder">No expiring items.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="section" style="margin-top:18px;">
                <div class="section-title" style="color:#fff; font-size:14px; margin-bottom:8px; display:flex; align-items:center; gap:6px;"><i class="fas fa-triangle-exclamation"></i> Expired</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Generic</th>
                            <th>Batch</th>
                            <th>Expiry</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($expired)): ?>
                            <?php foreach ($expired as $m): ?>
                                <tr>
                                    <td><?= esc($m['name'] ?? '') ?></td>
                                    <td><?= esc($m['generic_name'] ?? '') ?></td>
                                    <td><?= esc($m['batch_no'] ?? '') ?></td>
                                    <td><?= !empty($m['expiry_date']) ? esc(date('Y-m-d', strtotime($m['expiry_date']))) : '—' ?></td>
                                    <td><span class="badge danger">Expired</span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="placeholder">No expired items.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
