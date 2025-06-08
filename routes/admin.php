<?php
// routes/admin.php
// routes/web.php ou routes/admin.php
use Core\Router;

Router::setBasePath('/basephp'); 

// Rotas GET para o Admin
Router::get('/admin', 'Admin\\DashboardController@login'); // Dashboard padrão
Router::get('/admin/dashboard', 'Admin\\DashboardController@index');
Router::get('/admin/users', 'Admin\\AdminUsersController@index');
Router::get('/admin/users/{id}/edit', 'Admin\\AdminUsersController@edit');

// Rotas POST para o Admin
Router::post('/admin/users/{id}/update', 'Admin\\AdminUsersController@update');