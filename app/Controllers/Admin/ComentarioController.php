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
