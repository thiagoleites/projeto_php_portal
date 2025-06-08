<?php
// routes/web.php
// routes/web.php ou routes/admin.php
use Core\Router;

Router::setBasePath('/basephp');

// Rotas GET
Router::get('/', 'HomeController@index'); // Página inicial
Router::get('/about', 'HomeController@about'); // Exemplo de rota 'sobre'

// Rotas de Usuários (Site)
Router::get('/users', 'UserController@index'); // Lista de usuários
Router::get('/users/{id}', 'UserController@show'); // Exibir um usuário específico (ID dinâmico)
Router::get('/users/{id}/profile', 'UserController@profile'); 

// Exemplo de rota com callback (função anônima)
Router::get('/hello/{name}', function($name) {
    echo "Olá, " . htmlspecialchars($name) . "!";
});