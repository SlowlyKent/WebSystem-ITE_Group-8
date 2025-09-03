<?php include __DIR__.'/_layout_parts.php'; ?>
        <div class="card">
            <h2 style="display:flex; align-items:center; gap:8px;">
                <i class="fas fa-chart-bar"></i> Pharmacy Reports
            </h2>

            <form method="get" action="" class="search-bar" style="margin-top:8px; flex-wrap:wrap;">
                <input type="date" name="date_from" value="<?= esc($filters['date_from'] ?? '') ?>" placeholder="From">
                <input type="date" name="date_to" value="<?= esc($filters['date_to'] ?? '') ?>" placeholder="To">
                <select name="type" style="padding:8px 10px; border-radius:6px; border:1px solid #e9ecef;">
                    <option value="">All Types</option>
                    <option value="in" <?= ($filters['type'] ?? '')==='in' ? 'selected' : '' ?>>In (Receive)</option>
                    <option value="out" <?= ($filters['type'] ?? '')==='out' ? 'selected' : '' ?>>Out (Dispense)</option>
                    <option value="adjust" <?= ($filters['type'] ?? '')==='adjust' ? 'selected' : '' ?>>Adjust</option>
                </select>
                <select name="medicine_id" style="padding:8px 10px; border-radius:6px; border:1px solid #e9ecef; min-width:220px;">
                    <option value="">All Medicines</option>
                    <?php foreach ($medicines as $med): ?>
                        <option value="<?= (int)$med['id'] ?>" <?= !empty($filters['medicine_id']) && (int)$filters['medicine_id'] === (int)$med['id'] ? 'selected' : '' ?>>
                            <?= esc($med['name'].' ('.$med['sku'].')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="batch_no" value="<?= esc($filters['batch_no'] ?? '') ?>" placeholder="Batch #">
                <input type="text" name="q" value="<?= esc($filters['q'] ?? '') ?>" placeholder="Search name/sku/ref/notes">
                <button class="btn" type="submit"><i class="fas fa-search"></i> Filter</button>
                <a class="btn secondary" href="<?= current_url() ?>"><i class="fas fa-eraser"></i> Clear</a>
                <button class="btn" type="submit" name="export" value="csv"><i class="fas fa-file-csv"></i> Export CSV</button>
            </form>

            <div class="section-title" style="color:#fff; font-size:14px; margin-bottom:8px; display:flex; align-items:center; gap:6px;">
                <i class="fas fa-list"></i> Results (showing up to 200 rows)
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Medicine</th>
                        <th>SKU</th>
                        <th>Qty</th>
                        <th>Batch</th>
                        <th>Expiry</th>
                        <th>Reference</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($movements)): ?>
                        <?php foreach ($movements as $r): ?>
                            <tr>
                                <td><?= !empty($r['created_at']) ? esc(date('Y-m-d H:i', strtotime($r['created_at']))) : '—' ?></td>
                                <td>
                                    <?php if (($r['type'] ?? '') === 'in'): ?>
                                        <span class="badge" style="background:#0a3d26;color:#fff;">IN</span>
                                    <?php elseif (($r['type'] ?? '') === 'out'): ?>
                                        <span class="badge danger">OUT</span>
                                    <?php else: ?>
                                        <span class="badge warn">ADJ</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($r['med_name'] ?? '') ?></td>
                                <td><?= esc($r['med_sku'] ?? '') ?></td>
                                <td><?= esc($r['quantity'] ?? '') ?></td>
                                <td><?= esc($r['batch_no'] ?? '') ?></td>
                                <td><?= !empty($r['expiry_date']) ? esc(date('Y-m-d', strtotime($r['expiry_date']))) : '—' ?></td>
                                <td><?= esc($r['reference'] ?? '') ?></td>
                                <td><?= esc($r['notes'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="placeholder">No results.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
