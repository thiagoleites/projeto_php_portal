<?php
/**
 * ===============================================
 * TEMPORARY COMMIT MARKER
 * Branch: lint_tests
 * Date: 2026-02-18
 * Description: Temporary header for CI validation.
 * ===============================================
 */

declare(strict_types = 1);

namespace Core\Middleware; 

use Core\Auth;

class AdminhMiddleware
{
    public function handle(): void
    {
        if (!Auth::check()) {
            header('Location: /base/acesso-negado');
            exit;
        }
    }
}