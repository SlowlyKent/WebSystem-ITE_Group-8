<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details - HMS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #b9d3c9;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 270px;
            background-color: #052719;
            color: white;
            padding: 15px;
            border-radius: 15px;
            margin: 15px;
            height: calc(100vh - 30px);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .sidebar-header h4 {
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background-color: #ccc;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #666;
        }

        .sidebar-header p {
            font-size: 12px;
            margin-bottom: 5px;
            color: white;
        }

        .sidebar-header small {
            font-size: 10px;
            opacity: 0.8;
            color: white;
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

        .page-header {
            background-color: #052719;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            color: white;
            font-size: 24px;
        }

        .add-patient-btn {
            background-color: #b9d3c9;
            color: #052719;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .add-patient-btn:hover {
            background-color: #a8d5ba;
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-primary {
            background-color: #b9d3c9;
            color: #052719;
        }

        .btn-primary:hover {
            background-color: #a8d5ba;
        }

        /* Patient Table */
        .patient-table-container {
            background-color: #052719;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .patient-table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-table th {
            background-color: #052719;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 14px;
            font-weight: bold;
        }

        .patient-table td {
            padding: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 14px;
            color: white;
        }

        .patient-table tr:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .action-btn {
            padding: 5px 10px;
            margin-right: 5px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            transition: background-color 0.3s;
        }

        .edit-btn {
            background-color: #28a745;
            color: white;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .view-btn {
            background-color: #17a2b8;
            color: white;
        }

        .view-btn:hover {
            background-color: #138496;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #ccc;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #ccc;
        }

        /* Form Container */
        .form-container {
            background-color: #052719;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 800px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            color: white;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #b9d3c9;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        .required {
            color: #dc3545;
        }

        /* Patient Details */
        .patient-details {
            background-color: #052719;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .patient-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(255,255,255,0.2);
        }

        .patient-avatar {
            width: 80px;
            height: 80px;
            background-color: #b9d3c9;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #052719;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .detail-section {
            background-color: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #b9d3c9;
        }

        .detail-section h3 {
            color: white;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .detail-label {
            font-weight: bold;
            color: #ccc;
            min-width: 120px;
            margin-right: 15px;
        }

        .detail-value {
            color: white;
            flex: 1;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 10px;
            }
            
            .sidebar {
                display: none;
            }
            
            .details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('dashboard/_sidebar') ?>
    <div class="main-content">
        <?= isset($content) ? $content : '' ?>
    </div>
</body>
</html>
