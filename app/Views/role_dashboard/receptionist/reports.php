<?= $this->extend('role_dashboard/receptionist/layout') ?>
<?= $this->section('content') ?>

<style>
    /* --- Reports Page Styles --- */
    .reports-page {
        font-family: system-ui, Arial, sans-serif;
        padding: 20px;
        max-width: 1100px;
        margin: 40px auto;
        color: #333;
        border-radius: 20px;
    }

    /* Filters */
    .filters {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 25px;
    }
    .filters input,
    .filters select,
    .filters button {
        padding: 8px 12px;
        font-size: 0.95rem;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    .filters button {
        background: #052719;
        color: white;
        cursor: pointer;
    }
    .filters button:hover {
        background: #052719cc;
    }

    /* Summary cards */
    .summary {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 12px;
        margin-bottom: 30px;
    }
    .summary-card {
        border-radius: 8px;
        padding: 15px;
        color: white;
        text-align: center;
        background: #052719;
    }
    .summary-card h2 {
        margin: 0;
        font-size: 1.1rem;
    }
    .summary-card p {
        margin: 6px 0 0;
        font-size: 1.4rem;
        font-weight: bold;
    }

    /* Table */
    .table-container {
        background: #052719;
        padding: 15px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .reports-table {
        width: 100%;
        border-collapse: collapse;
        margin: 30px auto;
        font-size: 1rem;
        background-color: #052719;
    }

    .reports-table th,
    .reports-table td {
        padding: 15px;
        border: 1px solid #ccc;
        text-align: center;
        color: white;
    }

    .reports-table th {
        color: #052719;
        background-color: white;
        text-align: left;
    }

    .reports-table tr:hover {
        background: #1484556e;
    }
</style>

<div class="reports-page">

    <!-- Filters -->
    <div class="filters">
        <input type="date" placeholder="Start Date">
        <input type="date" placeholder="End Date">
        <select>
            <option value="">Select Report Type</option>
            <option>Billing</option>
            <option>Appointments</option>
            <option>Patients</option>
        </select>
        <button>Filter</button>
    </div>

    <!-- Summary Cards -->
    <div class="summary">
        <div class="summary-card">
            <h2>Total Patients</h2>
            <p><?= esc($widgets['totalPatients']) ?></p>
        </div>
        <div class="summary-card">
            <h2>Paid Bills</h2>
            <p><?= esc($widgets['paidBills']) ?></p>
        </div>
        <div class="summary-card">
            <h2>Pending Bills</h2>
            <p><?= esc($widgets['pendingBills']) ?></p>
        </div>
        <div class="summary-card">
            <h2>Overdue</h2>
            <p><?= esc($widgets['overdue']) ?></p>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="table-container">
    <table class="reports-table">
        <thead>
            <tr>
                <th>Report ID</th>
                <th>Patient Name</th>
                <th>Type</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?= esc($report['id']) ?></td>
                    <td><?= esc($report['name']) ?></td>
                    <td><?= esc($report['type']) ?></td>
                    <td><?= esc($report['date']) ?></td>
                    <td><?= esc($report['status']) ?></td>
                    <td><?= esc($report['total']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

<?= $this->endSection() ?>