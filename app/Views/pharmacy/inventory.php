<?php include __DIR__.'/_layout_parts.php'; ?>
        <div class="card">
            <h2><i class="fas fa-boxes-stacked"></i> Inventory Management</h2>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert danger"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>
            <div class="search-bar">
                <form method="get" action="<?= base_url('pharmacy/inventory') ?>" style="display:flex; gap:8px; flex-wrap:wrap; width:100%;">
                    <input type="text" name="q" value="<?= esc($filters['q'] ?? '') ?>" placeholder="Search name, generic, SKU, or batch...">
                    <label style="display:flex; align-items:center; gap:6px; color:#ddd; font-size:12px;">
                        <input type="checkbox" name="low" value="1" <?= !empty($filters['low']) ? 'checked' : '' ?>> Low stock
                    </label>
                    <label style="display:flex; align-items:center; gap:6px; color:#ddd; font-size:12px;">
                        <input type="checkbox" name="expiring" value="1" <?= !empty($filters['expiring']) ? 'checked' : '' ?>> Expiring (≤30d)
                    </label>
                    <button class="btn" type="submit"><i class="fas fa-search"></i> Search</button>
                    <a class="btn secondary" href="<?= base_url('pharmacy/inventory') ?>"><i class="fas fa-eraser"></i> Clear</a>
                    <span style="flex:1"></span>
                    <a class="btn" href="<?= base_url('pharmacy/receive') ?>"><i class="fas fa-truck-loading"></i> Receive Stock</a>
                    <a class="btn" href="<?= base_url('pharmacy/medicines/create') ?>"><i class="fas fa-plus"></i> Add Medicine</a>
                </form>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Generic</th>
                        <th>SKU</th>
                        <th>Batch</th>
                        <th>Expiry</th>
                        <th>Qty</th>
                        <th>Reorder</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($medicines)): ?>
                        <?php foreach ($medicines as $m): ?>
                            <?php
                                $isLow = (int)($m['reorder_level'] ?? 0) > 0 && (int)($m['quantity'] ?? 0) <= (int)($m['reorder_level'] ?? 0);
                                $expiring = null;
                                if (!empty($m['expiry_date'])) {
                                    $expiring = strtotime($m['expiry_date']) <= strtotime('+30 days');
                                }
                            ?>
                            <tr>
                                <td><?= esc($m['name'] ?? '') ?></td>
                                <td><?= esc($m['generic_name'] ?? '') ?></td>
                                <td><?= esc($m['sku'] ?? '') ?></td>
                                <td><?= esc($m['batch_no'] ?? '') ?></td>
                                <td><?= !empty($m['expiry_date']) ? esc(date('Y-m-d', strtotime($m['expiry_date']))) : '—' ?></td>
                                <td><?= esc($m['quantity'] ?? 0) ?></td>
                                <td><?= esc($m['reorder_level'] ?? 0) ?></td>
                                <td>
                                    <?php
                                        $badges = [];
                                        if ($isLow) { $badges[] = '<span class="badge danger">Low</span>'; }
                                        if ($expiring) { $badges[] = '<span class="badge warn">Expiring</span>'; }
                                        echo !empty($badges) ? implode(' ', $badges) : '<span class="badge">OK</span>';
                                    ?>
                                </td>
                                <td class="actions">
                                    <a class="btn" href="<?= base_url('pharmacy/dispense') ?>"><i class="fas fa-prescription-bottle"></i> Dispense</a>
                                    <a class="btn secondary" href="<?= base_url('pharmacy/medicines/edit/'.$m['id']) ?>"><i class="fas fa-pen"></i> Edit</a>
                                    <form action="<?= base_url('pharmacy/medicines/delete/'.$m['id']) ?>" method="post" style="display:inline" onsubmit="return confirm('Delete this medicine?');">
                                        <?= csrf_field() ?>
                                        <button class="btn danger" type="submit"><i class="fas fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" style="text-align:center; color:#666;">No medicines found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
