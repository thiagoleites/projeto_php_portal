<?php
// routes/admin.php
// routes/web.php ou routes/admin.php
use Core\Router;
use Core\Middleware\{AuthMiddleware, AdminMiddleware};
// E suas classes de Controller
use App\Controllers\Site\HomeController;
use App\Controllers\Site\UserController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\AdminUsersController;

Router::setBasePath('/'); 

// Rotas GET para o Admin
Router::get('/admin', 'Admin\\DashboardController@login'); // Dashboard padrão
Router::get('/admin/dashboard', 'Admin\\DashboardController@index', [AuthMiddleware::class]);

// Rotas Artigos
Router::get('/admin/artigos', 'Admin\\PostController@index');
Router::get('/admin/artigos/criar', 'Admin\\PostController@create');

Router::get('/admin/usuarios', 'Admin\\AdminUsersController@index', [AuthMiddleware::class, AdminMiddleware::class]); // apenas admin pode acessar
Router::get('/admin/usuarios/{id}/editar', 'Admin\\AdminUsersController@edit');

// Rotas POST para o Admin
Router::post('/admin/usuarios/{id}/atualizar', 'Admin\\AdminUsersController@update');

Router::get('/admin/categorias', 'Admin\\CategoriaController@index');
Router::get('/admin/categorias/criar', 'Admin\\CategoriaController@create');

Router::get('/admin/comentarios', 'Admin\\ComentarioController@index');