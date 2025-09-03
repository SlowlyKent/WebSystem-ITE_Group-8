<?php include __DIR__.'/_layout_parts.php'; ?>
        <div class="card">
            <h2 style="display:flex; align-items:center; gap:8px;"><i class="fas fa-file-medical"></i> Prescription #<?= esc($rx['id'] ?? '-') ?></h2>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="notice-bar" style="margin-bottom:12px; background:rgba(10,61,38,0.35);"><i class="fas fa-check-circle"></i> <?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="notice-bar" style="margin-bottom:12px; background:rgba(163,29,29,0.35);"><i class="fas fa-triangle-exclamation"></i> <?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <div class="section-title" style="color:#fff; font-size:14px; margin-bottom:8px; display:flex; align-items:center; gap:6px;">
                <i class="fas fa-prescription"></i> Items
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Dose / Frequency</th>
                        <th>Qty Prescribed</th>
                        <th>Refills</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $it): ?>
                            <tr>
                                <td>#<?= (int)$it['medicine_id'] ?></td>
                                <td><?= esc(($it['dose_text'] ?? '').' / '.($it['frequency_text'] ?? '')) ?></td>
                                <td><?= esc($it['qty_prescribed'] ?? '') ?></td>
                                <td><?= esc(($it['refills_used'] ?? 0).'/'.($it['refills_allowed'] ?? 0)) ?></td>
                                <td><a class="btn" href="<?= base_url('pharmacy/lookup/dispense/'.(int)$it['id']) ?>"><i class="fas fa-prescription-bottle"></i> Dispense</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="placeholder">No items.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
