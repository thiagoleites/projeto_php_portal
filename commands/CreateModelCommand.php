<?php

class CreateModelCommand {
    public function handle($modelName) {
        if (!$modelName) {
            echo "Você deve informar o nome do modelo.\n";
            return;
        }

        $dir = __DIR__ . '/../app/Models';
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

        namespace App\Models;
        
        use Core\Database\Model;

        class $modelName extends Model
        {
            public function __construct()
            {
                // Construtor model
            }
        }

        PHP;

        if (file_exists($filePath)) {
            echo "Modelo já existe: $filePath\n";
            return;
        }

        file_put_contents($filePath, $conteudo);
        echo "Modelo criado com sucesso em: $filePath\n";
    }
}
