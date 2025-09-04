<?= $this->extend('role_dashboard/admin/_layout') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1><?= isset($patient) ? 'Edit Patient' : 'Add New Patient' ?></h1>
    <a href="<?= base_url('patients') ?>" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Patient List
    </a>
</div>

<div class="form-container">
    <form action="<?= isset($patient) ? base_url('patients/update/' . $patient['id']) : base_url('patients/store') ?>" method="post">
        <?= $this->include('role_dashboard/admin/PatientRegistration/_patient_form_fields') ?>
        <div class="form-actions">
            <a href="<?= base_url('patients') ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                <?= isset($patient) ? 'Update Patient' : 'Add Patient' ?>
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
