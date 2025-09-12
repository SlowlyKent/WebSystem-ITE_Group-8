<?= $this->extend('role_dashboard/admin/_layout') ?>

<?= $this->section('content') ?>
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-database"></i> Database Status – HMS_Felicia</h1>
            <p style="color: #b9d3c9; margin-top: 5px;">Real-time database monitoring and system health</p>
        </div>
    </div>

    <!-- Top Status Cards -->
    <div class="db-status-container">
        <div class="db-status-card connection-status">
            <div class="status-header">
                <h3><i class="fas fa-plug"></i> Connection Status</h3>
            </div>
            <div class="status-content">
                <div class="connection-info">
                    <span class="status-indicator <?= $connection['status'] ? 'connected' : 'disconnected' ?>">
                        <?= $connection['status'] ? '✅ Connected' : '❌ Disconnected' ?>
                    </span>
                    <div class="connection-details">
                        <p><strong>Server:</strong> <?= esc($connection['server']) ?></p>
                        <p><strong>Database:</strong> <?= esc($connection['database']) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Storage Usage -->
        <div class="db-status-card storage-usage">
            <div class="status-header">
                <h3><i class="fas fa-hdd"></i> Storage Usage</h3>
            </div>
            <div class="status-content">
                <div class="storage-info">
                    <div class="storage-item">
                        <span class="storage-label">Total DB Size:</span>
                        <span class="storage-value"><?= esc($storage['total_size']) ?></span>
                    </div>
                    <div class="storage-item">
                        <span class="storage-label">Largest Table:</span>
                        <span class="storage-value"><?= esc($storage['largest_table']) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="db-status-card recent-activity">
            <div class="status-header">
                <h3><i class="fas fa-clock"></i> Recent Activity</h3>
            </div>
            <div class="status-content">
                <div class="activity-info">
                    <div class="activity-item">
                        <span class="activity-label">Last Query Run:</span>
                        <span class="activity-value"><?= esc($activity['last_query']) ?></span>
                    </div>
                    <div class="activity-item">
                        <span class="activity-label">Execution Time:</span>
                        <span class="activity-value"><?= esc($activity['execution_time']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Overview -->
    <?php foreach ($tables as $tableName => $tableData): ?>
        <div class="db-status-card individual-table">
            <div class="status-header">
                <h3><i class="fas fa-table"></i> <?= esc(ucwords(str_replace('_', ' ', $tableName))) ?> Table</h3>
                <span class="record-count">
                    <?= is_array($tableData) ? esc($tableData['count']) : esc($tableData) ?> records
                </span>
            </div>
            <div class="status-content">
                <?php if (is_array($tableData) && !empty($tableData['records'])): ?>
                    <div class="table-data">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <?php foreach ($tableData['columns'] as $column): ?>
                                        <th><?= esc(ucwords(str_replace('_', ' ', $column))) ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tableData['records'] as $record): ?>
                                    <tr>
                                        <?php foreach ($tableData['columns'] as $column): ?>
                                            <td><?= esc($record[$column] ?? 'N/A') ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if ($tableData['count'] > 10): ?>
                            <div class="table-footer">
                                <small>Showing first 10 records of <?= esc($tableData['count']) ?> total</small>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php elseif (is_array($tableData) && empty($tableData['records'])): ?>
                    <div class="no-data">
                        <p>No records found or table is empty</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

    <!-- Refresh Button -->
    <div class="refresh-section">
        <button onclick="location.reload()" class="refresh-btn">
            <i class="fas fa-sync-alt"></i> Refresh Status
        </button>
    </div>
<?= $this->endSection() ?>
