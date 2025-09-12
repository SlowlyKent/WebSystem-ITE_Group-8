<?= $this->extend('role_dashboard/receptionist/layout') ?>
<?= $this->section('content') ?>

<style>
    .billing-container {
        display: flex;
        gap: 20px;
        background: #052719;
        border-radius: 12px;
        padding: 20px;
        margin: 30px;
        color: #fff;
        font-family: system-ui, Arial, sans-serif;
    }

    /* Left form */
    .billing-form {
        flex: 1;
        background: #0a3a27;
        padding: 20px;
        border-radius: 10px;
    }

    .billing-form h2 {
        margin-bottom: 15px;
        font-size: 1.2rem;
        border-bottom: 2px solid #15af6f;
        padding-bottom: 8px;
    }

    .billing-form label {
        display: block;
        margin-top: 10px;
        font-size: 0.9rem;
    }

    .billing-form input,
    .billing-form select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 0.9rem;
    }

    .billing-form button {
        margin-top: 15px;
        width: 100%;
        padding: 10px;
        background: #15af6f;
        border: none;
        color: white;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
    }

    .billing-form button:hover {
        background: #11925d;
    }

    /* Right side summary */
    .billing-summary {
        flex: 2;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 12px;
    }

    .card {
        background: #fafafa;
        border-radius: 8px;
        padding: 12px;
        color: #222;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }

    .card h3 {
        margin: 0 0 6px;
        font-size: 1rem;
    }

    .card p {
        margin: 0;
        font-size: 0.85rem;
    }

    /* Status colors */
    .past-due { border-left: 15px solid #d9534f; }
    .pending  { border-left: 15px solid #f0ad4e; }
    .unpaid   { border-left: 15px solid #0275d8; }
    .paid     { border-left: 15px solid #5cb85c; }
</style>

<div class="billing-container">
    <!-- Left: Billing Form -->
    <div class="billing-form">
        <h2>Process Bill</h2>
        <form>
            <label>Patient Name</label>
            <input type="text" placeholder="Enter patient name">

            <label>Service</label>
            <input type="text" placeholder="e.g. Consultation">

            <label>Amount</label>
            <input type="number" placeholder="Enter amount">

            <label>Due Date</label>
            <input type="date">

            <label>Status</label>
            <select>
                <option>Pending</option>
                <option>Unpaid</option>
                <option>Paid</option>
                <option>Past Due</option>
            </select>

            <button type="button">Submit</button>
        </form>
    </div>

    <!-- Right: Billing Summary -->
    <div class="billing-summary">
        <?php foreach ($pastDue as $p): ?>
            <div class="card past-due">
                <h3><?= esc($p['name']) ?></h3>
                <p>Due: <?= esc($p['due']) ?></p>
                <hr>
                <p>Details: </p>
            </div>
        <?php endforeach; ?>

        <?php foreach ($unpaid as $u): ?>
            <div class="card unpaid">
                <h3><?= esc($u['name']) ?></h3>
                <p>Due: <?= esc($u['due']) ?></p>
                <hr>
                <p>Details: </p>
            </div>
        <?php endforeach; ?>

        <?php foreach ($pending as $p): ?>
            <div class="card pending">
                <h3><?= esc($p['name']) ?></h3>
                <p>Due: <?= esc($p['due']) ?></p>
                <hr>
                <p>Details: </p>
            </div>
        <?php endforeach; ?>

        <?php foreach ($paid as $p): ?>
            <div class="card paid">
                <h3><?= esc($p['name']) ?></h3>
                <p>Paid on: <?= esc($p['date']) ?></p>
                <hr>
                <p>Details: </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>