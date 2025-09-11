<?= $this->extend('role_dashboard/receptionist/layout') ?>
<?= $this->section('content') ?>

<style>
/* Box wrapper */
.inside-box {
    background-color: #052719;
    min-height: 250px;
    border-radius: 10px;
    padding: 40px;
    margin: 30px 50px;
    color: white;
}

/* Form fields */
.patient-form .form-group {
    margin-bottom: 12px;
}

.patient-form label {
    display: block;
    margin-bottom: 4px;
    font-weight: 600;
    color: white;
}

.patient-form input,
.patient-form select,
.patient-form textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 0.95rem;
    color: black;
}

/* Button */
.patient-form button {
    background: #ffffff;
    color: #052719;
    padding: 8px 15px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.2s ease;
}

.patient-form button:hover {
    background: #f1f1f1;
    transform: scale(1.03);
}
</style>

<!-- Patient Registration Form -->
<div class="inside-box">
    <form id="patientRegistrationForm" method="post" action="#" class="patient-form">
        
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">-- Select Gender --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="contact">Contact Number:</label>
            <input type="text" id="contact" name="contact" placeholder="09XXXXXXXXX">
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="3"></textarea>
        </div>

        <div class="form-group" style="text-align:right;">
            <button type="submit">Register Patient</button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>