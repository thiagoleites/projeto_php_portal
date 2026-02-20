<?php

/**
 * ===============================================
 * TEMPORARY COMMIT MARKER
 * Branch: lint_tests
 * Date: 2026-02-18
 * Description: Temporary header for CI validation.
 * ===============================================
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
