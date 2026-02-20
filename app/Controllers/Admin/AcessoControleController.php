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


use Core\Controller;

class AcessoControleController extends Controller
{
    public function erro()
    {
        echo "Erro, 404";
    }

    public function negado()
    {
        echo "Erro, Acesso negado!";
    }
}
