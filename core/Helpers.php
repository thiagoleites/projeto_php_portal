<?php
declare(strict_types=1);

namespace Core;

class Helpers
{
    public const DB_HOST    = 'localhost';
    public const DB_USER    = 'root';
    public const DB_PASS    = '';
    public const DB_NAME    = 'base_teste';
    public const DB_CHARSET = 'utf8mb4';
    public const DB_PORT    = '3306';
    public const DB_COLLATE = 'utf8mb4_general_ci';


    public const DB_DSN = 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=' . self::DB_CHARSET . ';port=' . self::DB_PORT;
    public const DB_OPTIONS = [
        \PDO::ATTR_ERRMODE              => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE   => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES     => false,
    ];
    public const DB_CONNECTION = [
        'host'      => self::DB_HOST,
        'user'      => self::DB_USER,
        'password'  => self::DB_PASS,
        'dbname'    => self::DB_NAME,
        'charset'   => self::DB_CHARSET,
        'port'      => self::DB_PORT,
        'collate'   => self::DB_COLLATE,
    ];

    public const URL_BASE = [
        'protocol'  => 'http',
        'host'      => 'localhost',
        'admin'     => '/base/admin',
        'base'      => '/base',
        'web'       => '/base/site',
        'public'    => '/base/public',
    ];

    public static function getBaseUri(): string
    {
        if (isset($_SERVER['CONTEXT_PREFIX'])) {
            return rtrim($_SERVER['CONTEXT_PREFIX'], '/');
        }

        return '';
    }

    public static function debug(): void
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    public static function recursive($value): ?array
    {
        $result = [];
        foreach ((array) $value as $item) {
            if (is_array($item)) {
                $result[] = array_merge($result, self::recursive($item));
            }
        }
        return $result;
    }

    public static function session(string $key, $value = null): mixed
    {
        if ($value !== null) {
            $_SESSION[$key] = $value;
            return true;
        } elseif (isset($_SESSION[$key])) {
            $result = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $result;
        }

        return null;
    }
}
