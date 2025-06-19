<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        AuthController.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\View;
use App\Models\User;
use Core\Auth;

class AuthController
{
    public function login() {}

    public function authenticate()
    {
        $user = User::where('email', $_POST['email'])->first();

        if ($user && password_verify($_POST['password'], $user['password'])) {
            Auth::login([
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'is_admin' => (bool)$user['is_admin'],
            ]);

            header('Location: /projeto/dashboard');
            exit();
        }
        
    }
}
