<?php include __DIR__.'/_layout_parts.php'; ?>
        <div class="card">
            <h2 style="display:flex; align-items:center; gap:8px;"><i class="fas fa-file-medical"></i> Patient Prescription Lookup</h2>

            <form method="get" action="" class="search-bar" style="margin-top:8px; flex-wrap:wrap;">
                <input type="text" name="patient" value="<?= esc($filters['patient'] ?? '') ?>" placeholder="Patient name">
                <input type="text" name="mrn" value="<?= esc($filters['mrn'] ?? '') ?>" placeholder="MRN/ID">
                <input type="date" name="date_from" value="<?= esc($filters['date_from'] ?? '') ?>" placeholder="From">
                <input type="date" name="date_to" value="<?= esc($filters['date_to'] ?? '') ?>" placeholder="To">
                <select name="status" style="padding:8px 10px; border-radius:6px; border:1px solid #e9ecef;">
                    <option value="">All Status</option>
                    <option value="active" <?= ($filters['status'] ?? '')==='active'?'selected':'' ?>>Active</option>
                    <option value="partial" <?= ($filters['status'] ?? '')==='partial'?'selected':'' ?>>Partially filled</option>
                    <option value="fulfilled" <?= ($filters['status'] ?? '')==='fulfilled'?'selected':'' ?>>Fulfilled</option>
                    <option value="expired" <?= ($filters['status'] ?? '')==='expired'?'selected':'' ?>>Expired</option>
                </select>
                <input type="text" name="q" value="<?= esc($filters['q'] ?? '') ?>" placeholder="Search notes">
                <button class="btn" type="submit"><i class="fas fa-search"></i> Search</button>
                <a class="btn secondary" href="<?= current_url() ?>"><i class="fas fa-eraser"></i> Clear</a>
            </form>

            <div class="section-title" style="color:#fff; font-size:14px; margin-bottom:8px; display:flex; align-items:center; gap:6px;">
                <i class="fas fa-list"></i> Results (up to 100)
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $rx): ?>
                            <tr>
                                <td>#<?= (int)$rx['id'] ?></td>
                                <td><?= esc($rx['date'] ?? '') ?></td>
                                <td><span class="badge <?= ($rx['status']==='fulfilled'?'':'warn') ?>"><?= esc(ucfirst($rx['status'] ?? '')) ?></span></td>
                                <td><?= esc($rx['notes'] ?? '') ?></td>
                                <td>
                                    <a class="btn" href="<?= base_url('pharmacy/lookup/view/'.(int)$rx['id']) ?>"><i class="fas fa-eye"></i> View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="placeholder">No prescriptions found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
