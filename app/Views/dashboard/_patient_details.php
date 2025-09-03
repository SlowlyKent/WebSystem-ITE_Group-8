<div class="patient-details">
    <div class="patient-header">
        <div class="patient-avatar">
            <i class="fas fa-user"></i>
        </div>
        <h2 style="color: white;"><?= esc($patient['first_name']) ?> <?= esc($patient['middle_name']) ?> <?= esc($patient['last_name']) ?></h2>
        <p style="color: #ccc;">Patient ID: #<?= $patient['id'] ?></p>
        <span class="status-badge <?= $patient['status'] === 'active' ? 'status-active' : 'status-inactive' ?>">
            <?= ucfirst($patient['status']) ?>
        </span>
    </div>

    <div class="details-grid">
        <!-- Personal Information -->
        <div class="detail-section">
            <h3><i class="fas fa-user"></i> Personal Information</h3>
            <div class="detail-row">
                <span class="detail-label">First Name:</span>
                <span class="detail-value"><?= esc($patient['first_name']) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Middle Name:</span>
                <span class="detail-value"><?= esc($patient['middle_name']) ?: '—' ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Last Name:</span>
                <span class="detail-value"><?= esc($patient['last_name']) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date of Birth:</span>
                <span class="detail-value"><?= date('M d, Y', strtotime($patient['date_of_birth'])) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Gender:</span>
                <span class="detail-value"><?= ucfirst($patient['gender']) ?></span>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="detail-section">
            <h3><i class="fas fa-phone"></i> Contact Information</h3>
            <div class="detail-row">
                <span class="detail-label">Phone:</span>
                <span class="detail-value"><?= esc($patient['phone']) ?: '—' ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span class="detail-value"><?= esc($patient['email']) ?: '—' ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Address:</span>
                <span class="detail-value"><?= esc($patient['address']) ?: '—' ?></span>
            </div>
        </div>

        <!-- Medical Information -->
        <div class="detail-section">
            <h3><i class="fas fa-stethoscope"></i> Medical Information</h3>
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    <span class="status-badge <?= $patient['status'] === 'active' ? 'status-active' : 'status-inactive' ?>">
                        <?= ucfirst($patient['status']) ?>
                    </span>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Room:</span>
                <span class="detail-value"><?= esc($patient['room']) ?: '—' ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Medical Notes:</span>
                <span class="detail-value"><?= esc($patient['medical_notes']) ?: '—' ?></span>
            </div>
        </div>

        <!-- System Information -->
        <div class="detail-section">
            <h3><i class="fas fa-info-circle"></i> System Information</h3>
            <div class="detail-row">
                <span class="detail-label">Created:</span>
                <span class="detail-value"><?= date('M d, Y H:i', strtotime($patient['created_at'])) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Last Updated:</span>
                <span class="detail-value"><?= date('M d, Y H:i', strtotime($patient['updated_at'])) ?></span>
            </div>
        </div>
    </div>
</div>
