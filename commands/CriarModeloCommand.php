<?php

class CriarModeloCommand
{
    public function executar(string $nome)
    {
        $classe = ucfirst($nome);
        $caminho = __DIR__ . '/../app/Models';
        $arquivo = $caminho . "/{$classe}.php";

        if (!is_dir($caminho)) {
            mkdir($caminho, 0777, true);
        }

        if(file_exists($arquivo)) {
            echo "O modelo '$classe' já existe em app/Model/ . \n";
            return;
        }

        $conteudo = <<<PHP
        <?php

        declare(strict_types=1);

        namespace App\Models;

        class $classe
        {
            // Inserir métodos do modelo.
        }
        PHP;

        file_put_contents($arquivo, $conteudo);
        echo "Modelo '$classe' criado com sucesso em App/Models/. \n";
    }
}