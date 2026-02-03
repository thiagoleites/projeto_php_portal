<?php
declare(strict_types = 1);

namespace Core\Middleware; 

use Core\Auth;

class AuthMiddleware
{
    public function handle(): void
    {
        if (!Auth::check()) {
            header('Location: /base/admin/login');
            exit;
        }
    }
}