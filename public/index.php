<?php
// Inicializar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ .'/../core/Autoloader.php'; // Se estiver usando Composer
require_once __DIR__ . '/../core/Router.php'; // Inclua a classe Router

// Inclua seus arquivos de rotas
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/admin.php'; // Inclua as rotas do admin

// Router::setBasePath('');
Core\Router::setBasePath('/base'); // Define o prefixo base para as rotas

Core\Router::dispatch();