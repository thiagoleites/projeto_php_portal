<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        DashboardController.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\View;

class DashboardController
{
    public function index()
    {
        
        // View::render('admin/dashboard', [
        //     'titulo'    => 'Dashboard - Painel de controle',
        //     'conteudo'  => 'Bem-vindo ao painel de controle!',
        // ]);

        View::setArea('admin');
        View::render('pages/dashboard', [
            'titulo'    => 'Dashboard - Painel de controle',
        ]);
    }
}