<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        ComentarioController.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\View;

class ComentarioController
{
    public function index()
    {
        View::setArea('admin');
        View::render('pages/comentarios/index', [
            'titulo' => 'Moderação de Comentários',
            'subtitulo' => 'Gerencie os comentários enviados pelos usuários.'
        ]);
    }
}
