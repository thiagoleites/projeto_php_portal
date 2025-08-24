<?php
/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 * File: PostController.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\View;

class PostController
{
    public function index()
    {
        View::setArea('admin');
        View::render('pages/artigos/index', [
            'titulo' => 'Listagem de Artigos',
            'subtitulo' => 'Gerencie todos os seus artigos publicados e rascunhos.'
        ]);
    }

    public function create()
    {
        View::setArea('admin');
        View::render('pages/artigos/criar', [
            'titulo' => 'Criar novo Artigo',
            'subtitulo' => 'Preencha os campos abaixo para publicar ou salvar um rascunho.'
        ]);
    }
}
