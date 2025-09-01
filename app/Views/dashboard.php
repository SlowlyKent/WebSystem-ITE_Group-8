<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <h1>Welcome to the Hospital Management System</h1>
    <p>You are logged in!</p>
    <a href="<?= base_url('patients') ?>">Patient Registration & EHR</a> <!-- Added link for Patient Registration & EHR -->
    <a href="<?= base_url('logout') ?>">Logout</a>
</body>
</html>
