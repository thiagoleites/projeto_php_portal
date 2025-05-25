<?php

class CreateControllerCommand {
    public function handle($controllerName) {
        if (!$controllerName) {
            echo "Você deve informar o nome do controller.\n";
            return;
        }

        $dir = __DIR__ . '/../app/Controllers';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $filePath = "$dir/{$controllerName}Controller.php";
        $conteudo = "<?php\n\nclass {$controllerName}Controller {\n    // Controller $controllerName\n}\n";

        if (file_exists($filePath)) {
            echo "Controller já existe: $filePath\n";
            return;
        }

        file_put_contents($filePath, $conteudo);
        echo "Controller criado com sucesso em: $filePath\n";
    }
}
