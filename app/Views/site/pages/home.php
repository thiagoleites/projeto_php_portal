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

View::extend('layouts/main');

View::start('content'); ?>

    <div class="home">
        <h1>Bem-vindo ao nosso site</h1>
    </div>

    <?php View::script('
        <script>
        $(document).ready(function() {
            console.log("Funcionou!");
        });
        </script>
    '); ?>
<?php View::end(); ?>