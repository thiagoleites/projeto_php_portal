<?php
use Core\View;

View::extend('layouts/main');

View::start('content'); ?>
    <h1>Bem-vindo ao nosso site</h1>

    <?php View::script('
        <script>
        $(document).ready(function() {
            console.log("Funcionou!");
        });
        </script>
    '); ?>
<?php View::end(); ?>