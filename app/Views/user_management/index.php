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
            background-color: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-fluid {
            width: 100%;
            padding: 0 20px;
        }

        .py-4 {
            padding: 2rem 0;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0 10px;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .card-header {
            background: var(--primary-color, #0d6efd);
            color: white;
            padding: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-light {
            background: white;
            color: var(--primary-color, #0d6efd);
        }

        .btn-light:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            background: transparent;
            color: var(--primary-color, #0d6efd);
            border: 2px solid var(--primary-color, #0d6efd);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color, #0d6efd);
            color: white;
        }

        .btn-outline-danger {
            background: transparent;
            color: #dc3545;
            border: 2px solid #dc3545;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            padding: 12px;
            text-align: left;
            background: #f8f9fa;
            color: #495057;
        }

        .table td {
            padding: 12px;
            border-top: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .role-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
        }

        .role-admin { background: #dc3545; color: white; }
        .role-it_staff { background: #fd7e14; color: white; }
        .role-doctor { background: #0d6efd; color: white; }
        .role-nurse { background: #198754; color: white; }
        .role-pharmacist { background: #6f42c1; color: white; }
        .role-receptionist { background: #6c757d; color: white; }

        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .bg-success { background: #198754; color: white; }
        .bg-secondary { background: #6c757d; color: white; }
        .bg-warning { background: #ffc107; color: #212529; }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            border: none;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .text-center {
            text-align: center;
        }

        .py-5 {
            padding: 3rem 0;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .text-muted {
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 10px;
            }
            
            .table-responsive {
                font-size: 14px;
            }
            
            .btn-sm {
                padding: 4px 8px;
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-users-cog"></i> User Management
                            </h4>
                            <a href="<?= base_url('user-management/create') ?>" class="btn btn-light">
                                <i class="fas fa-plus"></i> Add New User
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i>
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td>
                                            <strong><?= $user['username'] ?></strong>
                                        </td>
                                        <td><?= $user['first_name'] . ' ' . $user['last_name'] ?></td>
                                        <td><?= $user['email'] ?></td>
                                        <td>
                                            <span class="role-badge role-<?= $user['role'] ?>">
                                                <?= ucfirst(str_replace('_', ' ', $user['role'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($user['status'] === 'active'): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php elseif ($user['status'] === 'inactive'): ?>
                                                <span class="badge bg-secondary">Inactive</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Suspended</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?= base_url('user-management/edit/' . $user['id']) ?>" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if ($user['id'] != session()->get('userId')): ?>
                                                <a href="<?= base_url('user-management/delete/' . $user['id']) ?>" 
                                                   class="btn btn-outline-danger btn-sm"
                                                   onclick="return confirm('Are you sure you want to deactivate this user?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if (empty($users)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users" style="font-size: 3rem; color: #dee2e6;"></i>
                            <p class="text-muted mt-3">No users found</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
