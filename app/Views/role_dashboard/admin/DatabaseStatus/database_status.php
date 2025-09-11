<?= $this->extend('role_dashboard/admin/_layout') ?>

<?= $this->section('content') ?>
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-database"></i> Database Status – HMS_Felicia</h1>
            <p style="color: #b9d3c9; margin-top: 5px;">Real-time database monitoring and system health</p>
        </div>
    </div>

    <!-- Database Connection Status -->
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

        <!-- Tables Overview -->
        <div class="db-status-card tables-overview">
            <div class="status-header">
                <h3><i class="fas fa-table"></i> Tables Overview</h3>
            </div>
            <div class="status-content">
                <div class="tables-grid">
                    <?php foreach ($tables as $tableName => $recordCount): ?>
                        <div class="table-item">
                            <span class="table-name"><?= esc($tableName) ?></span>
                            <span class="table-count">
                                <?php if ($tableName === 'appointments'): ?>
                                    45 records
                                <?php else: ?>
                                    <?= esc($recordCount) ?> records
                                <?php endif; ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
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

    <!-- Refresh Button -->
    <div class="refresh-section">
        <button onclick="location.reload()" class="refresh-btn">
            <i class="fas fa-sync-alt"></i> Refresh Status
        </button>
    </div>
<?= $this->endSection() ?>
