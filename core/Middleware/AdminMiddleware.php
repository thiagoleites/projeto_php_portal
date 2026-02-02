<?php
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