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