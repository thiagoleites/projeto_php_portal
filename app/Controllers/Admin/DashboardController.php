<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\View;

class DashboardController
{
    public function index()
    {
        
        View::render('admin/dashboard', [
            'titulo'    => 'Dashboard - Painel de controle',
            'conteudo'  => 'Bem-vindo ao painel de controle!',
        ]);
    }
}