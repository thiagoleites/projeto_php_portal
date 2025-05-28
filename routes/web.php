<?php
// routes/web.php
use Core\Router;
use App\Controllers\Site\HomeController;
use App\Controllers\Site\UserController;

// Defina o caminho base da sua aplicação (se ela estiver em um subdiretório)
Router::setBasePath('/projeto');

// Rotas GET
Router::get('/', HomeController::class . '@index'); // Rota para a página inicial
Router::get('/about', HomeController::class . '@about'); // Exemplo de rota 'sobre'
Router::get('/users', UserController::class . '@index'); // Lista de usuários
Router::get('/users/{id}', UserController::class . '@show'); // Exibir um usuário específico (ID dinâmico)
Router::get('/users/{id}/profile', UserController::class . '@profile'); // Perfil de usuário com ID

// Rotas POST
Router::post('/users/create', UserController::class . '@store'); // Para processar o formulário de criação de usuário
Router::post('/users/{id}/update', UserController::class . '@update'); // Para processar o formulário de atualização

// Exemplo de rota com callback (função anônima)
Router::get('/hello/{name}', function($name) {
    echo "Olá, " . htmlspecialchars($name) . "!";
});