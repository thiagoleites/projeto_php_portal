<?php
/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 * File: Auth.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types = 1);

namespace Core; 

use App\Models\User;

class Auth
{

    private static array $user = [];

    public static function login(array $userData): void
    {
        $_SESSION['user'] = $userData;
        self::$user = $userData;
    }

    public static function logout(): void
    {
        session_destroy();
        self::$user = null;
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return self::check() && ($_SESSION['user']['is_admin'] ?? false);
    }

}