<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - HMS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/docnurse.css') ?>">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar Navigation -->
        <?= $this->include('role_dashboard/doctor/_doctor_sidebar') ?>

        <!-- Main Content -->
        <main class="main">
            <header class="header">
                <div class="header-info">
                    <i class="fas fa-user-injured"></i> Patient Records
                </div>
                <div class="header-info">
                    <span class="doctor-name">Dr. <?= esc(session()->get('fullName') ?? 'Doctor') ?></span>
                </div>
            </header>


            <!-- Enhanced Search and Filter Controls -->
            <div class="controls-container">
                <div class="search-section">
                    <div class="search-bar">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="patientSearch" class="search-input" placeholder="Search by name, phone, email, room, or medical notes...">
                        <button class="btn btn-primary search-btn" onclick="clearSearch()">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                    <div class="search-results-info">
                        <span id="searchResults">Showing all patients</span>
                    </div>
                </div>
                
                <div class="filter-section">
                    <div class="unified-filter-box">
                        <div class="filter-group">
                            <label>Filter by Status:</label>
                            <div class="filter-buttons">
                                <button class="filter-btn active" data-filter="all" onclick="filterPatients('all')">
                                    All <span class="count" id="count-all"><?= count($patients ?? []) ?></span>
                                </button>
                                <button class="filter-btn" data-filter="active" onclick="filterPatients('active')">
                                    Active <span class="count" id="count-active"><?= count(array_filter($patients ?? [], function($p) { return strtolower($p['status'] ?? '') === 'active'; })) ?></span>
                                </button>
                                <button class="filter-btn" data-filter="admitted" onclick="filterPatients('admitted')">
                                    Admitted <span class="count" id="count-admitted"><?= count(array_filter($patients ?? [], function($p) { return strtolower($p['status'] ?? '') === 'admitted'; })) ?></span>
                                </button>
                                <button class="filter-btn" data-filter="critical" onclick="filterPatients('critical')">
                                    Critical <span class="count" id="count-critical"><?= count(array_filter($patients ?? [], function($p) { return strtolower($p['status'] ?? '') === 'critical'; })) ?></span>
                                </button>
                                <button class="filter-btn" data-filter="discharged" onclick="filterPatients('discharged')">
                                    Discharged <span class="count" id="count-discharged"><?= count(array_filter($patients ?? [], function($p) { return strtolower($p['status'] ?? '') === 'discharged'; })) ?></span>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </div>

                        <!-- Patient Table -->
            <div class="patient-table-container">
                <?php if (!empty($patients)): ?>
                    <table class="patient-table" id="patientTable">
                        <thead>
                            <tr>
                                <th>Patient Info</th>
                                <th>Age/Gender</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Room/Location</th>
                                <th>Medical Notes</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($patients as $patient): ?>
                                <tr data-status="<?= strtolower($patient['status'] ?? 'active') ?>">
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-avatar">
                                                <?= strtoupper(substr($patient['first_name'], 0, 1) . substr($patient['last_name'], 0, 1)) ?>
                                            </div>
                                            <div class="patient-details">
                                                <h4><?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?></h4>
                                                <p>ID: <?= esc($patient['id']) ?></p>
                                                <?php if (!empty($patient['date_of_birth'])): ?>
                                                    <p>DOB: <?= date('M d, Y', strtotime($patient['date_of_birth'])) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                        $age = 'N/A';
                                        if (!empty($patient['date_of_birth'])) {
                                            $dob = new DateTime($patient['date_of_birth']);
                                            $now = new DateTime();
                                            $age = $now->diff($dob)->y;
                                        }
                                        ?>
                                        <strong><?= $age ?> years</strong><br>
                                        <small><?= esc($patient['gender'] ?? 'N/A') ?></small>
                                    </td>
                                    <td>
                                        <div class="medical-info">
                                            <?php if (!empty($patient['phone'])): ?>
                                                <i class="fas fa-phone"></i> <?= esc($patient['phone']) ?><br>
                                            <?php endif; ?>
                                            <?php if (!empty($patient['email'])): ?>
                                                <i class="fas fa-envelope"></i> <?= esc($patient['email']) ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($patient['status'] ?? 'active') ?>">
                                            <?= esc($patient['status'] ?? 'Active') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (!empty($patient['room'])): ?>
                                            <i class="fas fa-bed"></i> <?= esc($patient['room']) ?>
                                        <?php else: ?>
                                            <span class="text-muted">Not assigned</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="medical-info">
                                            <?php if (!empty($patient['medical_notes'])): ?>
                                                <?= esc(substr($patient['medical_notes'], 0, 50)) ?><?= strlen($patient['medical_notes']) > 50 ? '...' : '' ?>
                                            <?php else: ?>
                                                <span class="text-muted">No notes</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                        $updatedAt = $patient['updated_at'] ?? $patient['created_at'] ?? '';
                                        if ($updatedAt) {
                                            $date = new DateTime($updatedAt);
                                            echo $date->format('M d, Y');
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?= base_url('doctor/patient/' . $patient['id']) ?>" class="btn btn-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-success" onclick="addNote(<?= $patient['id'] ?>)" title="Add Note">
                                                <i class="fas fa-notes-medical"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-patients">
                        <i class="fas fa-user-injured"></i>
                        <h3>No Patients Found</h3>
                        <p>No patient records are currently available in the database.</p>
                    </div>
                <?php endif; ?>
            </div>
            </div>
        </main>
    </div>

    <script>
        let currentFilter = 'all';
        
        // Enhanced search functionality
        function searchPatients() {
            const searchValue = document.getElementById('patientSearch').value.toLowerCase();
            performSearch(searchValue);
        }

        // Clear search
        function clearSearch() {
            document.getElementById('patientSearch').value = '';
            performSearch('');
            updateSearchResults('Showing all patients');
        }

        // Real-time search with debouncing
        let searchTimeout;
        document.getElementById('patientSearch').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchValue = this.value.toLowerCase();
            
            searchTimeout = setTimeout(() => {
                performSearch(searchValue);
            }, 300); // 300ms delay for better performance
        });

        // Enhanced search function
        function performSearch(searchValue) {
            const table = document.getElementById('patientTable');
            if (!table) return;

            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            let visibleCount = 0;
            let totalCount = rows.length;

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let matchesSearch = false;
                let matchesStatusFilter = true;

                // Search criteria - more comprehensive
                if (searchValue === '') {
                    matchesSearch = true;
                } else {
                    const searchableText = [
                        cells[0]?.textContent || '', // Patient info
                        cells[1]?.textContent || '', // Age/Gender
                        cells[2]?.textContent || '', // Contact
                        cells[4]?.textContent || '', // Room
                        cells[5]?.textContent || '', // Medical notes
                    ].join(' ').toLowerCase();
                    
                    matchesSearch = searchableText.includes(searchValue);
                }

                // Status filter
                const rowStatus = row.getAttribute('data-status');
                if (currentFilter !== 'all') {
                    matchesStatusFilter = rowStatus === currentFilter;
                }

                const shouldShow = matchesSearch && matchesStatusFilter;
                row.style.display = shouldShow ? '' : 'none';
                
                if (shouldShow) visibleCount++;
            }

            // Update search results info
            if (searchValue) {
                updateSearchResults(`Found ${visibleCount} of ${totalCount} patients matching "${searchValue}"`);
            } else {
                updateSearchResults(`Showing ${visibleCount} patients`);
            }
        }

        // Filter by status
        function filterPatients(status) {
            currentFilter = status;
            
            // Update active filter button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-filter') === status) {
                    btn.classList.add('active');
                }
            });

            performSearch(document.getElementById('patientSearch').value.toLowerCase());
        }

        // Update search results display
        function updateSearchResults(message) {
            document.getElementById('searchResults').textContent = message;
        }

        // Quick action functions
        function addNote(patientId) {
            window.location.href = `<?= base_url('doctor/patient/') ?>${patientId}#notes`;
        }

        function prescribe(patientId) {
            window.location.href = `<?= base_url('doctor/prescription/') ?>${patientId}`;
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial state
            currentFilter = 'all';
            
            // Initial search to show all patients
            performSearch('');
            
            // Focus search input for better UX
            document.getElementById('patientSearch').focus();
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + F to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                document.getElementById('patientSearch').focus();
            }
            
            // Escape to clear search
            if (e.key === 'Escape') {
                clearSearch();
            }
        });
    </script>
</body>
</html>
