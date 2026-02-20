<?php
/**
 * ===============================================
 * TEMPORARY COMMIT MARKER
 * Branch: lint_tests
 * Date: 2026-02-18
 * Description: Temporary header for CI validation.
 * ===============================================
 */


class CreateAdmCommand {
    public function handle($modelName) {
        if (!$modelName) {
            echo "Você deve informar o nome do modelo.\n";
            return;
        }

        $dir = __DIR__ . '/../app/Controllers/Admin';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $filePath = "$dir/$modelName.php";
        $conteudo = "<?php\n\nclass $modelName {\n    // Model $modelName\n}\n";

        $conteudo = <<<PHP
        <?php
        /**
         * ---------------------------------------------------------------------
         * Project:     Sistema personalizado em PHP
         * Author:      Thiago Leite - Devt Digital
         * License:     Proprietary - Todos os direitos reservados
         * File:        $modelName.php
         * Description: Classe responsável pela construção de queries SQL
         * ---------------------------------------------------------------------
         * Copyright (c) 2025 Devt Digital
         * Thiago Leite <tls@devt.emp.br>
         * ---------------------------------------------------------------------
         */
        declare(strict_types=1);

        namespace App\Controllers\Admin;
        

        class $modelName
        {
            public function index()
            {
                // Lógica para listar os itens
            }
        }

        PHP;

        if (file_exists($filePath)) {
            echo "Controller já existe: $filePath\n";
            return;
        }

        file_put_contents($filePath, $conteudo);
        echo "Controller criado com sucesso em: $filePath\n";
    }
}
