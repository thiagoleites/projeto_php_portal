<?php
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

    /**
     * Função para deslogar e remover sessão no sistema
     *
     * @return void
     */
    public static function logout(): void
    {
        session_destroy();
//        self::$user = null;
        self::$user = [];
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