<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - HMS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            min-height: 100vh;
            width: 100%;
        }

        .dashboard {
            display: flex;
            width: 100%;
            min-height: 100vh; 
            background: #b9d3c9;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 270px;
            background-color: #052719;
            color: white;
            padding: 15px;
            border-radius: 15px;
            height: calc(100vh - 30px);
            position: fixed;
            left: 15px;
            top: 15px;
            z-index: 1000;
            overflow-y: auto;
        }

        /* Main Content */
        .main {
            flex: 1;
            padding: 40px 40px 40px 340px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-height: 100vh;
            width: 100%;
        }

        .header {
            background: #81c798;
            height: 60px;
            border-radius: 15px;
            box-shadow: 0 10px 10px rgba(0,0,0,.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            color: #052719;
            font-weight: bold;
            gap: 10px;
            margin-bottom: 20px;
        }

        .header-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background-color: #14524a;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0f3d37;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
            padding: 5px 10px;
            font-size: 12px;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 3px 6px rgba(0,0,0,.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }

        .stat-icon.total { background: #007bff; }
        .stat-icon.active { background: #28a745; }
        .stat-icon.admitted { background: #ffc107; }
        .stat-icon.critical { background: #dc3545; }

        .stat-info h3 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        .stat-info p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        /* Enhanced Search and Filters */
        .controls-container {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 6px rgba(0,0,0,.1);
            margin-bottom: 20px;
        }

        .search-section {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .search-bar {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            color: #666;
            z-index: 1;
        }

        .search-input {
            flex: 1;
            padding: 12px 15px 12px 45px;
            border: 2px solid #ddd;
            border-radius: 25px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .search-input:focus {
            outline: none;
            border-color: #14524a;
        }

        .search-btn {
            padding: 12px 20px;
            border-radius: 25px;
        }

        .search-results-info {
            font-size: 13px;
            color: #666;
            font-style: italic;
        }

        .filter-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .unified-filter-box {
            padding: 15px;

        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-group label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .filter-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 15px;
            border: 2px solid #ddd;
            background: #fff;
            border-radius: 20px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .filter-btn:hover {
            border-color: #14524a;
            background: #f8f9fa;
        }

        .filter-btn.active {
            background: #14524a;
            color: white;
            border-color: #14524a;
        }

        .filter-btn .count {
            background: rgba(255,255,255,0.2);
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
        }

        .filter-btn.active .count {
            background: rgba(255,255,255,0.3);
        }


        /* Patient Table */
        .patient-table-container {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 6px rgba(0,0,0,.1);
        }

        .patient-table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-table thead {
            background: #559680;
            color: white;
        }

        .patient-table th,
        .patient-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .patient-table th {
            font-weight: 600;
            font-size: 14px;
        }

        .patient-table td {
            font-size: 13px;
        }

        .patient-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .patient-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            max-width: 250px;
        }

        .patient-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #14524a;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }

        .patient-details {
            flex: 1;
            min-width: 0;
        }

        .patient-details h4 {
            margin: 0 0 2px 0;
            font-size: 14px;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .patient-details p {
            margin: 0;
            font-size: 12px;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-admitted {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-discharged {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-critical {
            background-color: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .medical-info {
            font-size: 12px;
            color: #666;
        }

        .medical-info .vital {
            display: inline-block;
            margin-right: 10px;
        }

        .no-patients {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .no-patients i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main {
                padding: 20px 20px 20px 320px;
            }
        }

        @media (max-width: 992px) {
            .dashboard {
                flex-direction: column;
            }
            
            .main {
                width: 100%;
                padding: 15px;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .search-bar {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }

            .patient-table {
                font-size: 12px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }

        .sidebar-header small {
            font-size: 10px;
            opacity: 0.8;
        }

        .nav-menu ul {
            list-style: none;
        }

        .nav-menu li {
            margin-bottom: 3px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background-color 0.3s;
            font-size: 12px;
        }

        .nav-menu a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .nav-menu a.active {
            background-color: rgba(255,255,255,0.2);
        }

        .nav-menu i {
            margin-right: 8px;
            width: 14px;
            font-size: 12px;
        }

        .logout-section {
            position: absolute;
            bottom: 15px;
            left: 15px;
            right: 15px;
        }

        .logout-section a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            border: 1px solid white;
            border-radius: 6px;
            transition: background-color 0.3s;
            font-size: 12px;
        }

        .logout-section a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        /* Main Content */
        .main-content {
            margin-left: 300px;
            padding: 20px;
            min-height: 100vh;
        }


        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }


        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-primary {
            background-color: #14524a;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0f3d37;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .patient-table-container {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 6px rgba(0,0,0,.1);
        }

        .patient-table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-table thead {
            background: #559680;
            color: white;
        }

        .patient-table th,
        .patient-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .patient-table th {
            font-weight: 600;
            font-size: 14px;
        }

        .patient-table td {
            font-size: 13px;
        }

        .patient-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-discharged {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-admitted {
            background-color: #fff3cd;
            color: #856404;
        }

        .no-patients {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .no-patients i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-input {
            width: 300px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }   
        .search-bar {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 10px 12px;
            border-radius: 20px;
            box-shadow: 0 3px 6px rgba(0,0,0,.1);
            gap: 10px;
            margin-top: 10px;
            width: 100%;
        }

        .search-bar input {
            border: none;
            outline: none;
            flex: 1;
            font-size: 14px;
        }

        .patient-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .patient-avatar {
            width: 32px;
            height: 32px;
            background-color: #052719;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main {
                padding: 20px 20px 20px 320px;
            }
        }

        @media (max-width: 992px) {
            .dashboard {
                padding: 15px;
                flex-direction: column;
            }
            
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                margin: 0 0 20px 0;
                left: 0;
                top: 0;
                border-radius: 10px;
            }

            .main {
                width: 100%;
                padding: 15px;
            }

            .header {
                flex-direction: column;
                height: auto;
                padding: 15px;
                gap: 15px;
            }
        }

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }

            .patient-table {
                font-size: 12px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
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
