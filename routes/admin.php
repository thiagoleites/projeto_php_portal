<?php
// routes/admin.php
// routes/web.php ou routes/admin.php
use Core\Router;
// E suas classes de Controller
use App\Controllers\Site\HomeController;
use App\Controllers\Site\UserController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\AdminUsersController;

Router::setBasePath('/'); 

// Rotas GET para o Admin
Router::get('/admin', 'Admin\\DashboardController@login'); // Dashboard padrão
Router::get('/admin/dashboard', 'DashboardController@index');
Router::get('/admin/users', 'AdminUsersController@index');
Router::get('/admin/users/{id}/edit', 'AdminUsersController@edit');

// Rotas POST para o Admin
Router::post('/admin/users/{id}/update', 'AdminUsersController@update');