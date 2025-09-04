<?= $this->extend('role_dashboard/admin/_layout') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>Patient List</h1>
    <a href="<?= base_url('patients/create') ?>" class="add-patient-btn">
        <i class="fas fa-plus"></i> Add New Patient
    </a>
</div>

<?= $this->include('role_dashboard/admin/PatientRegistration/_patient_table') ?>
<?= $this->endSection() ?>
