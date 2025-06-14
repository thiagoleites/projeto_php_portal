<?php
// public/index.php ou bootstrap.php
require_once __DIR__ .'/../core/Autoloader.php'; // Se estiver usando Composer
require_once __DIR__ . '/../core/Router.php'; // Inclua a classe Router

// Inclua seus arquivos de rotas
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/admin.php'; // Inclua as rotas do admin
use App\Models\User;
use Core\Router;

// Router::setBasePath('');
Core\Router::setBasePath('/projeto'); // Define o prefixo base para as rotas
// Despacha a requisição

// Router::get('/', function() {
//     echo "Bem-vindo à página inicial via projeto.local!";
// });
Core\Router::dispatch();



/*
use Core\Database\Connection;

try {
    // Teste 1: Obter instância
    $connection = Connection::getInstance();
    echo "Instância obtida com sucesso! <br>";
    
    // Teste 2: Obter conexão MySQLi
    $mysqli = $connection->getConnection();
    echo "Conexão MySQLi obtida. Thread ID: " . $mysqli->thread_id . "<br>";
    
    // Teste 3: Verificar se é singleton
    $anotherInstance = Connection::getInstance();
    if ($connection === $anotherInstance) {
        echo "Singleton funcionando - mesma instância <br>";
    }
    
    // Teste 4: Fechar conexão
    $connection->close();
    echo "Conexão fechada <br>";
    
    // Teste 5: Nova instância após fechar
    $newConnection = Connection::getInstance();
    if ($connection !== $newConnection) {
        echo "Nova instância criada após fechar<br>";
    }
    
    // Teste 6: Executar query simples
    $result = $newConnection->getConnection()->query("SELECT * FROM temp_users LIMIT 1");
    if ($result) {
        echo "Query teste executada com sucesso<br>";
        $user = $result->fetch_all();
        var_dump($user);
        $result->free();
    }
    
} catch (Exception $e) {
    echo "ERRO: " . $e->getMessage() . "<br>";
}
*/

// $usuario = (new User())->query()
//     ->select(['name', 'email'])
//     ->first();

// var_dump($usuario);