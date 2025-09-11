<?= $this->extend('role_dashboard/receptionist/layout') ?>
<?= $this->section('content') ?>

<style>
    .search-container {
        width: 100%;
        min-height: 80vh; /* take most of the screen */
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .search-container form {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
    }

    .search-container input[type="text"] {
        flex: 1;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 1rem;
    }

    .search-container button {
        padding: 12px 20px;
        background: #052719;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.3s ease;
    }

    .search-container button:hover {
        background: #094d2f;
    }

    .search-results {
        margin-top: 20px;
    }

    .search-results h3 {
        margin-bottom: 15px;
    }

    .search-results table {
        width: 100%;
        border-collapse: collapse;
        font-size: 1rem;
    }

    .search-results th,
    .search-results td {
        padding: 14px;
        border: 1px solid #ccc;
        text-align: center;
    }

    .search-results th {
        background: #052719;
        color: white;
    }

    .search-results tr:nth-child(even) {
        background: #f9f9f9;
    }

    .search-results tr:hover {
        background: #eef7f1;
    }
</style>

<div class="search-container">
    <form method="get" action="<?= base_url('receptionist/patientsearch_lookup') ?>">
        <input type="text" name="keyword" placeholder="Enter patient name, ID, or contact" required>
        <button type="submit">Search</button>
    </form>

    <div class="search-results">
        <h3>Search Results</h3>
        <?php if (!empty($patients)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Full Name</th>
                        <th>Contact</th>
                        <th>Date of Birth</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $p): ?>
                        <tr>
                            <td><?= esc($p['id']) ?></td>
                            <td><?= esc($p['fullName']) ?></td>
                            <td><?= esc($p['contact']) ?></td>
                            <td><?= esc($p['dob']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">No patient records found.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
