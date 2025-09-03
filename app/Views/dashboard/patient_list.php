<div class="page-header">
    <h1>Patient List</h1>
    <a href="<?= base_url('patients/create') ?>" class="add-patient-btn">
        <i class="fas fa-plus"></i> Add New Patient
    </a>
</div>

<?= $this->include('dashboard/_patient_table') ?>
