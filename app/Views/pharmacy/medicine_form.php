<?php include __DIR__.'/_layout_parts.php'; ?>
        <div class="card">
            <h2 style="display:flex; align-items:center; gap:8px;">
                <i class="fas fa-pills"></i>
                <?= isset($medicine) && $medicine ? 'Edit Medicine' : 'Add Medicine' ?>
            </h2>

            <style>
                .form-grid { display:grid; grid-template-columns: repeat(12, 1fr); gap:14px; margin-top:12px; }
                .field { display:flex; flex-direction:column; gap:6px; }
                .field label { color:#ddd; font-size:12px; }
                .field input, .field select { padding:10px 12px; border-radius:6px; border:1px solid rgba(255,255,255,0.15); background:rgba(255,255,255,0.06); color:#fff; outline:none; }
                .field small { color:#9fb5ad; font-size:11px; }
                .invalid input { border-color:#a31d1d; }
                .invalid small { color:#ffb3b3; }
                .section { margin-top:18px; padding:12px; border:1px dashed rgba(255,255,255,0.15); border-radius:8px; }
                .section-title { color:#fff; font-size:13px; margin-bottom:8px; display:flex; align-items:center; gap:6px; opacity:0.95; }
                .btns { margin-top:16px; display:flex; gap:8px; }
                @media (max-width: 900px) { .form-grid { grid-template-columns: repeat(6, 1fr); } }
                @media (max-width: 600px) { .form-grid { grid-template-columns: repeat(1, 1fr); } }
            </style>

            <?php $errors = session()->getFlashdata('errors') ?? []; ?>
            <?php if (!empty($errors)): ?>
                <div class="alert danger" style="margin-top:12px;">
                    <strong>Please fix the highlighted fields.</strong>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= isset($medicine) && $medicine ? base_url('pharmacy/medicines/update/'.$medicine['id']) : base_url('pharmacy/medicines/store') ?>">
                <?= csrf_field() ?>

                <div class="section">
                    <div class="section-title"><i class="fas fa-info-circle"></i> Basic Information</div>
                    <div class="form-grid">
                        <div class="field <?= isset($errors['name']) ? 'invalid' : '' ?>" style="grid-column: span 6;">
                            <label>Name *</label>
                            <input type="text" name="name" required placeholder="e.g. Amoxicillin 500mg" value="<?= esc(set_value('name', $medicine['name'] ?? '')) ?>">
                            <small><?= isset($errors['name']) ? esc($errors['name']) : 'Official product name as shown on the label.' ?></small>
                        </div>
                        <div class="field" style="grid-column: span 6;">
                            <label>Generic Name</label>
                            <input type="text" name="generic_name" placeholder="e.g. Amoxicillin" value="<?= esc(set_value('generic_name', $medicine['generic_name'] ?? '')) ?>">
                            <small>Active ingredient or generic name.</small>
                        </div>
                        <div class="field" style="grid-column: span 6;">
                            <label>Category</label>
                            <input type="text" name="category" placeholder="e.g. Antibiotic" value="<?= esc(set_value('category', $medicine['category'] ?? '')) ?>">
                            <small>Group or class (Antibiotic, Analgesic, etc.).</small>
                        </div>
                        <div class="field" style="grid-column: span 6;">
                            <label>Unit</label>
                            <input type="text" name="unit" placeholder="tablet, capsule, bottle..." value="<?= esc(set_value('unit', $medicine['unit'] ?? '')) ?>">
                            <small>Packaging unit (tablet, capsule, bottle, vial, etc.).</small>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title"><i class="fas fa-barcode"></i> Identification</div>
                    <div class="form-grid">
                        <div class="field <?= isset($errors['sku']) ? 'invalid' : '' ?>" style="grid-column: span 6;">
                            <label>SKU</label>
                            <input type="text" name="sku" placeholder="Stock keeping unit" value="<?= esc(set_value('sku', $medicine['sku'] ?? '')) ?>">
                            <small>
                                <?php if (empty($medicine)): ?>
                                    <?= isset($errors['sku']) ? esc($errors['sku']) : 'Leave blank to auto-generate a unique SKU.' ?>
                                <?php else: ?>
                                    <?= isset($errors['sku']) ? esc($errors['sku']) : 'Optional internal code for tracking.' ?>
                                <?php endif; ?>
                            </small>
                        </div>
                        <div class="field <?= isset($errors['batch_no']) ? 'invalid' : '' ?>" style="grid-column: span 6;">
                            <label>Batch No.</label>
                            <input type="text" name="batch_no" placeholder="e.g. BATCH-A1" value="<?= esc(set_value('batch_no', $medicine['batch_no'] ?? '')) ?>">
                            <small><?= isset($errors['batch_no']) ? esc($errors['batch_no']) : 'Batch/Lot number (if applicable).' ?></small>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title"><i class="fas fa-boxes"></i> Stock & Pricing</div>
                    <div class="form-grid">
                        <div class="field <?= isset($errors['quantity']) ? 'invalid' : '' ?>" style="grid-column: span 4;">
                            <label>Quantity *</label>
                            <input type="number" min="0" name="quantity" required value="<?= esc(set_value('quantity', $medicine['quantity'] ?? 0)) ?>">
                            <small><?= isset($errors['quantity']) ? esc($errors['quantity']) : 'Current on-hand stock.' ?></small>
                        </div>
                        <div class="field <?= isset($errors['reorder_level']) ? 'invalid' : '' ?>" style="grid-column: span 4;">
                            <label>Reorder Level</label>
                            <input type="number" min="0" name="reorder_level" value="<?= esc(set_value('reorder_level', $medicine['reorder_level'] ?? 0)) ?>">
                            <small><?= isset($errors['reorder_level']) ? esc($errors['reorder_level']) : 'Alert threshold for low stock.' ?></small>
                        </div>
                        <div class="field <?= isset($errors['price']) ? 'invalid' : '' ?>" style="grid-column: span 4;">
                            <label>Price</label>
                            <input type="number" step="0.01" min="0" name="price" placeholder="0.00" value="<?= esc(set_value('price', $medicine['price'] ?? 0)) ?>">
                            <small><?= isset($errors['price']) ? esc($errors['price']) : 'Unit price (optional).' ?></small>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title"><i class="fas fa-hourglass-half"></i> Expiry</div>
                    <div class="form-grid">
                        <div class="field <?= isset($errors['expiry_date']) ? 'invalid' : '' ?>" style="grid-column: span 4;">
                            <label>Expiry Date</label>
                            <input type="date" name="expiry_date" value="<?= esc(set_value('expiry_date', isset($medicine['expiry_date']) && $medicine['expiry_date'] ? date('Y-m-d', strtotime($medicine['expiry_date'])) : '')) ?>">
                            <small><?= isset($errors['expiry_date']) ? esc($errors['expiry_date']) : 'Leave empty if not applicable.' ?></small>
                        </div>
                    </div>
                </div>

                <div class="btns">
                    <button class="btn" type="submit"><i class="fas fa-save"></i> Save</button>
                    <a class="btn secondary" href="<?= base_url('pharmacy/inventory') ?>"><i class="fas fa-arrow-left"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
