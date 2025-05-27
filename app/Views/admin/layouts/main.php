<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Painel Administrativo' ?></title>
    
    <!-- CSS Admin -->
    <link href="/assets/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/admin/css/admin.css" rel="stylesheet">
    
    <?php View::section('head'); ?>
</head>
<body class="admin">
    <?php View::partial('admin/partials/header'); ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php View::partial('admin/partials/sidebar'); ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php View::section('content'); ?>
            </main>
        </div>
    </div>
    
    <?php View::partial('admin/partials/footer'); ?>
    
    <!-- JS Admin -->
    <script src="/assets/admin/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/js/admin.js"></script>
    
    <?php View::scripts(); ?>
</body>
</html>