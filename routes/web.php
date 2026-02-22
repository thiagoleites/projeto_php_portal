<?php
use Core\Router;
use Core\Middleware\{AuthMiddleware, AdminMiddleware};
// E suas classes de Controller
use App\Controllers\Site\HomeController;
use App\Controllers\Site\UserController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\AdminUsersController;

// Defina o caminho base da sua aplicação (se ela estiver em um subdiretório)
Router::setBasePath('/');

// Rotas GET
Router::get('/', 'HomeController@index'); // Página inicial
Router::get('/about', 'HomeController@about'); // Exemplo de rota 'sobre' para uar como base para adição de novas rotas

// Rotas de Usuários (Site)
Router::get('/users', 'UserController@index'); // Lista de usuários
Router::get('/users/{id}', 'UserController@show'); // Exibir um usuário específico (ID dinâmico)
Router::get('/users/{id}/profile', 'UserController@profile'); 

// Exemplo de rota com callback (função anônima)
Router::get('/hello/{name}', function($name) {
    echo "Olá, " . htmlspecialchars($name) . "!";
});