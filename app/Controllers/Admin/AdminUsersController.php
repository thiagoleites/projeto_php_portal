<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\User;
use Core\View;

class AdminUsersController
{
    public function index(): void
    {

        $allUsers = User::getAllUsers();

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
