<?php
use Core\View;

View::extend('layouts/main');

View::start('content'); ?>
    <h1>Bem-vindo ao nosso site</h1>
    
    <?php View::script('<script src="/js/jquery.min.js"></script>'); ?>
    <?php View::script('
        <script>
        $(document).ready(function() {
            alert("Funcionou!");
        });
        </script>
    '); ?>
<?php View::end(); ?>