<div class="page-header">
    <h1>Patient Details</h1>
    <div class="action-buttons">
        <a href="<?= base_url('patients') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
        <a href="<?= base_url('patients/edit/' . $patient['id']) ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Patient
        </a>
    </div>
</div>

<?= $this->include('dashboard/_patient_details') ?>
