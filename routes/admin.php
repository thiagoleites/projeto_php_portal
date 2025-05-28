<?php
// routes/admin.php
use Core\Router;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\AdminUsersController; 

Router::setBasePath('/projeto'); 

// Rotas GET para o Admin
Router::get('/admin', DashboardController::class . '@login'); // Dashboard padrão
Router::get('/admin/dashboard', DashboardController::class . '@index');
Router::get('/admin/users', AdminUsersController::class . '@index');
Router::get('/admin/users/{id}/edit', AdminUsersController::class . '@edit');

// Rotas POST para o Admin
Router::post('/admin/users/{id}/update', AdminUsersController::class . '@update');