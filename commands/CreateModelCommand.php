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

        if (file_exists($filePath)) {
            echo "Modelo já existe: $filePath\n";
            return;
        }

        file_put_contents($filePath, $conteudo);
        echo "Modelo criado com sucesso em: $filePath\n";
    }
}
