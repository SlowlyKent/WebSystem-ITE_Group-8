<?php include __DIR__.'/_layout_parts.php'; ?>
        <div class="card">
            <h2 style="display:flex; align-items:center; gap:8px;"><i class="fas fa-prescription-bottle"></i> Dispense</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="notice-bar" style="margin-bottom:12px; background:rgba(163,29,29,0.35);"><i class="fas fa-triangle-exclamation"></i> <?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <?php if (!$item || !$medicine): ?>
                <div class="placeholder">Invalid item.</div>
            <?php else: ?>
                <div class="section-title" style="color:#fff; font-size:14px; margin-bottom:8px; display:flex; align-items:center; gap:6px;">
                    <i class="fas fa-capsules"></i> Item Details
                </div>
                <table class="table">
                    <tr><th>Medicine ID</th><td><?= (int)$item['medicine_id'] ?></td></tr>
                    <tr><th>Current Stock</th><td><?= (int)($medicine['quantity'] ?? 0) ?></td></tr>
                    <tr><th>Qty Prescribed</th><td><?= (int)($item['qty_prescribed'] ?? 0) ?></td></tr>
                </table>

                <form method="post" class="actions" style="margin-top:12px;">
                    <input type="number" name="quantity_dispensed" min="1" step="1" placeholder="Quantity" required>
                    <input type="text" name="notes" placeholder="Notes (optional)">
                    <button class="btn" type="submit"><i class="fas fa-check"></i> Confirm Dispense</button>
                    <a class="btn secondary" href="<?= base_url('pharmacy/lookup/view/'.(int)$item['prescription_id']) ?>"><i class="fas fa-arrow-left"></i> Back</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
