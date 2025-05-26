<?php

require_once '../core/Autoloader.php';
require_once '../core/Router.php';

use App\Models\User;
use Core\Router;

Router::dispatch();

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
    $result = $newConnection->getConnection()->query("SELECT 1");
    if ($result) {
        echo "Query teste executada com sucesso<br>";
        $result->free();
    }
    
} catch (Exception $e) {
    echo "ERRO: " . $e->getMessage() . "<br>";
}

*/

$user = (new User())->query()
    ->select(['name'])
    ->first();

var_dump($user);