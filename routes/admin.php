<?php

use Core\Router;
use Core\Middleware\{AuthMiddleware, AdminMiddleware};

Router::setBasePath('/'); 

// Rotas GET para o Admin
Router::get('/admin', 'Admin\\LoginController@index'); // Dashboard padrão
//Route::get('/login', \App\Controllers\Admin\LoginController@)
//Router::get('/admin/dashboard', 'Admin\\DashboardController@index', [AuthMiddleware::class]);
Router::get('/admin/dashboard', 'Admin\\DashboardController@index');

// Rotas Artigos
Router::get('/admin/artigos', 'Admin\\PostController@index');
Router::get('/admin/artigos/criar', 'Admin\\PostController@create');

//Router::get('/admin/usuarios', 'Admin\\AdminUsersController@index', [AuthMiddleware::class, AdminMiddleware::class]); // apenas admin pode acessar
Router::get('/admin/usuarios', 'Admin\\AdminUsersController@index'); // apenas admin pode acessar
Router::get('/admin/usuarios/criar', 'Admin\\AdminUsersController@create'); // apenas admin pode acessar
Router::get('/admin/usuarios/{id}/editar', 'Admin\\AdminUsersController@edit');

// Rotas POST para o Admin
Router::post('/admin/usuarios/{id}/atualizar', 'Admin\\AdminUsersController@update');

Router::get('/admin/categorias', 'Admin\\CategoriaController@index');
Router::get('/admin/categorias/criar', 'Admin\\CategoriaController@create');

Router::get('/admin/comentarios', 'Admin\\ComentarioController@index');