<?php
/**
 * ===============================================
 * TEMPORARY COMMIT MARKER
 * Branch: lint_tests
 * Date: 2026-02-18
 * Description: Temporary header for CI validation.
 * ===============================================
 */

use Core\View;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Meu Site' ?></title>
    
    <!-- CSS Site -->
    <!-- <link href="/assets/site/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="<?= View::asset('css/style.css') ?>" rel="stylesheet">
    
    <?php View::section('head'); ?>
</head>
<body>
    <?php View::partial('site/partials/header'); ?>
    
    <main role="main">
        <?php View::section('content'); ?>
    </main>
    
    <?php View::partial('site/partials/footer'); ?>
    
    <!-- JS Site -->
    <script src="/base/js/jquery.js"></script>
    <?php View::scripts(); ?>
</body>
</html>