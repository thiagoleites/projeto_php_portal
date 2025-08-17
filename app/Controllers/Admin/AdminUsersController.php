<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        AdminUsersController.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\User;
use Core\View;

class AdminUsersController
{
    public function index()
    {

        $allUsers = User::getAllUsers();

//        var_dump($allUsers);
//        die;

        View::setArea('admin');
        View::render('pages/usuarios/index', [
            'titulo' => 'Listagem de Usuários',
            'subtitulo' => 'Gerencie os usuários do sistema.',
            'allUsers' => $allUsers,
        ]);
    }


    public function create()
    {
        View::setArea('admin');
        View::render('pages/usuarios/criar', [
            'titulo' => 'Criar um novo usuário',
            'subtitulo' => 'Preencha todos os campos'
        ]);
    }
}
