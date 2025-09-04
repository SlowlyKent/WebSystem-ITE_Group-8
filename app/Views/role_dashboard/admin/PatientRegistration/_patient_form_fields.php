<div class="form-grid">
    <div class="form-group">
        <label for="first_name">First Name <span class="required">*</span></label>
        <input type="text" id="first_name" name="first_name" value="<?= isset($patient) ? esc($patient['first_name']) : '' ?>" required>
    </div>

    <div class="form-group">
        <label for="middle_name">Middle Name</label>
        <input type="text" id="middle_name" name="middle_name" value="<?= isset($patient) ? esc($patient['middle_name']) : '' ?>">
    </div>

    <div class="form-group">
        <label for="last_name">Last Name <span class="required">*</span></label>
        <input type="text" id="last_name" name="last_name" value="<?= isset($patient) ? esc($patient['last_name']) : '' ?>" required>
    </div>

    <div class="form-group">
        <label for="date_of_birth">Date of Birth</label>
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?= isset($patient) ? esc($patient['date_of_birth']) : '' ?>">
    </div>

    <div class="form-group">
        <label for="gender">Gender</label>
        <select id="gender" name="gender">
            <option value="">Select Gender</option>
            <option value="Male" <?= (isset($patient) && $patient['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= (isset($patient) && $patient['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= (isset($patient) && $patient['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
        </select>
    </div>

    <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" value="<?= isset($patient) ? esc($patient['phone']) : '' ?>">
    </div>

    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="<?= isset($patient) ? esc($patient['email']) : '' ?>">
    </div>

    <div class="form-group">
        <label for="status">Status <span class="required">*</span></label>
        <select id="status" name="status" required>
            <option value="">Select Status</option>
            <option value="Active" <?= (isset($patient) && $patient['status'] == 'Active') ? 'selected' : '' ?>>Active</option>
            <option value="Inactive" <?= (isset($patient) && $patient['status'] == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
            <option value="Discharged" <?= (isset($patient) && $patient['status'] == 'Discharged') ? 'selected' : '' ?>>Discharged</option>
        </select>
    </div>

    <div class="form-group">
        <label for="room">Room Number</label>
        <select id="room" name="room">
            <option value="">Select Room</option>
            <!-- EMM Rooms (001-010) -->
            <?php for ($i = 1; $i <= 10; $i++): ?>
                <option value="EMM-<?= sprintf('%03d', $i) ?>" <?= (isset($patient) && $patient['room'] == 'EMM-' . sprintf('%03d', $i)) ? 'selected' : '' ?>>EMM-<?= sprintf('%03d', $i) ?></option>
            <?php endfor; ?>
            <!-- AGM Rooms (011-020) -->
            <?php for ($i = 11; $i <= 20; $i++): ?>
                <option value="AGM-<?= sprintf('%03d', $i) ?>" <?= (isset($patient) && $patient['room'] == 'AGM-' . sprintf('%03d', $i)) ? 'selected' : '' ?>>AGM-<?= sprintf('%03d', $i) ?></option>
            <?php endfor; ?>
            <!-- FGM Rooms (021-030) -->
            <?php for ($i = 21; $i <= 30; $i++): ?>
                <option value="FGM-<?= sprintf('%03d', $i) ?>" <?= (isset($patient) && $patient['room'] == 'FGM-' . sprintf('%03d', $i)) ? 'selected' : '' ?>>FGM-<?= sprintf('%03d', $i) ?></option>
            <?php endfor; ?>
            <!-- Annex Rooms (031-040) -->
            <?php for ($i = 31; $i <= 40; $i++): ?>
                <option value="Annex-<?= sprintf('%03d', $i) ?>" <?= (isset($patient) && $patient['room'] == 'Annex-' . sprintf('%03d', $i)) ? 'selected' : '' ?>>Annex-<?= sprintf('%03d', $i) ?></option>
            <?php endfor; ?>
        </select>
    </div>

    <div class="form-group full-width">
        <label for="address">Address</label>
        <textarea id="address" name="address" placeholder="Enter complete address"><?= isset($patient) ? esc($patient['address']) : '' ?></textarea>
    </div>

    <div class="form-group full-width">
        <label for="medical_notes">Medical Notes</label>
        <textarea id="medical_notes" name="medical_notes" placeholder="Any relevant medical information"><?= isset($patient) ? esc($patient['medical_notes']) : '' ?></textarea>
    </div>

    <!-- Insurance Information Section -->
    <div class="form-group">
        <label for="insurance_provider">Insurance Provider</label>
        <input type="text" id="insurance_provider" name="insurance_provider" value="<?= isset($insurance) ? esc($insurance['provider']) : '' ?>" placeholder="e.g., Blue Cross, Aetna">
    </div>

    <div class="form-group">
        <label for="insurance_policy">Policy Number</label>
        <input type="text" id="insurance_policy" name="insurance_policy" value="<?= isset($insurance) ? esc($insurance['policy']) : '' ?>" placeholder="Insurance policy number">
    </div>

    <!-- Medical Information Section -->
    <div class="form-group">
        <label for="blood_type">Blood Type</label>
        <select id="blood_type" name="blood_type">
            <option value="">Select Blood Type</option>
            <option value="A+" <?= (isset($medical_info) && $medical_info['blood_type'] == 'A+') ? 'selected' : '' ?>>A+</option>
            <option value="A-" <?= (isset($medical_info) && $medical_info['blood_type'] == 'A-') ? 'selected' : '' ?>>A-</option>
            <option value="B+" <?= (isset($medical_info) && $medical_info['blood_type'] == 'B+') ? 'selected' : '' ?>>B+</option>
            <option value="B-" <?= (isset($medical_info) && $medical_info['blood_type'] == 'B-') ? 'selected' : '' ?>>B-</option>
            <option value="AB+" <?= (isset($medical_info) && $medical_info['blood_type'] == 'AB+') ? 'selected' : '' ?>>AB+</option>
            <option value="AB-" <?= (isset($medical_info) && $medical_info['blood_type'] == 'AB-') ? 'selected' : '' ?>>AB-</option>
            <option value="O+" <?= (isset($medical_info) && $medical_info['blood_type'] == 'O+') ? 'selected' : '' ?>>O+</option>
            <option value="O-" <?= (isset($medical_info) && $medical_info['blood_type'] == 'O-') ? 'selected' : '' ?>>O-</option>
        </select>
    </div>

    <div class="form-group">
        <label for="allergies">Allergies</label>
        <input type="text" id="allergies" name="allergies" value="<?= isset($medical_info) ? esc($medical_info['allergies']) : '' ?>" placeholder="Known allergies (e.g., Penicillin, Peanuts)">
    </div>

    <div class="form-group full-width">
        <label for="existing_condition">Existing Conditions</label>
        <textarea id="existing_condition" name="existing_condition" placeholder="Pre-existing medical conditions"><?= isset($medical_info) ? esc($medical_info['existing_condition']) : '' ?></textarea>
    </div>

    <div class="form-group">
        <label for="primary_physician">Primary Physician</label>
        <input type="text" id="primary_physician" name="primary_physician" value="<?= isset($medical_info) ? esc($medical_info['primary_physician']) : '' ?>" placeholder="Dr. Name">
    </div>
</div>
