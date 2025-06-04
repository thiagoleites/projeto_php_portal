<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        HomeController.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

declare(strict_types=1);

namespace App\Controllers\Site;
use Core\View;

class HomeController
{
    /**
     * Método para exibir a página inicial do projeto Frontend.
     */
    public function index()
    {
        View::render('pages/home', [
            'titulo' => 'Página Inicial - Projeto Frontend',
        ]);
    }
}