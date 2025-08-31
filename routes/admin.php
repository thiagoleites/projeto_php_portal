<?php

use Core\Router;
use Core\Middleware\{AuthMiddleware, AdminMiddleware};

Router::setBasePath('/'); 

// Rotas GET para o Admin
Router::get('/admin', 'Admin\\LoginController@index'); // Dashboard padrão
Router::get('/admin/login', 'Admin\\AuthController@login'); // Página de login
Router::post('/admin/login', 'Admin\\AuthController@authenticate'); // ação de login
Router::get('/admin/dashboard', 'Admin\\DashboardController@index', [AuthMiddleware::class]);

Router::get('/admin/logout', 'Admin\\AuthController@logout', [AuthMiddleware::class]);
//Router::get('/admin/dashboard', 'Admin\\DashboardController@index');

// Rotas Artigos
Router::get('/admin/artigos', 'Admin\\PostController@index');
Router::get('/admin/artigos/criar', 'Admin\\PostController@create');

//Router::get('/admin/usuarios', 'Admin\\AdminUsersController@index', [AuthMiddleware::class, AdminMiddleware::class]); // apenas admin pode acessar
Router::get('/admin/usuarios', 'Admin\\AdminUsersController@index'); // apenas admin pode acessar
Router::get('/admin/usuarios/criar', 'Admin\\AdminUsersController@create'); // apenas admin pode acessar
Router::get('/admin/usuarios/{id}/editar', 'Admin\\AdminUsersController@edit');
Router::post('/admin/categorias/editar/{id}', 'Admin\\CategoriaController@update');
Router::post('/admin/categorias/excluir/{id}', 'Admin\\CategoriaController@delete');
Router::get('/admin/categorias/confirmar-exclusao/{id}', 'Admin\\CategoriaController@confirmDelete');

// Rotas POST para o Admin
Router::post('/admin/usuarios/{id}/atualizar', 'Admin\\AdminUsersController@update');

Router::get('/admin/categorias', 'Admin\\CategoriaController@index');
Router::get('/admin/categorias/criar', 'Admin\\CategoriaController@create');
Router::get('/admin/categorias/editar', 'Admin\\CategoriaController@edit');
Router::post('/admin/categorias/criar', 'Admin\\CategoriaController@store');

Router::get('/admin/comentarios', 'Admin\\ComentarioController@index');

// Direcionamento acesso negado
Router::get('/acesso-negado', 'Admin\\AcessoControleController@negado');


Router::get('/admin/hello/{name}', function($name) {
    echo "Olá, " . htmlspecialchars($name) . "!";
});