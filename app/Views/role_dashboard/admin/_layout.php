<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= isset($title) ? esc($title) . ' - HMS' : 'HMS' ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet" />
    <script src="<?= base_url('assets/js/script.js') ?>" defer></script>
</head>
<body>
    <?= $this->include('role_dashboard/admin/dashboard/_sidebar') ?>
    <div class="main-content">
        <?= $this->renderSection('content') ?>
    </div>
</body>
</html>
