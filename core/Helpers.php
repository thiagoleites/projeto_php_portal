<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        Helpers.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types=1);

namespace Core;

class Helpers
{
    public const DB_HOST = 'localhost';
    public const DB_USER = 'root';
    public const DB_PASS = '';
    public const DB_NAME = 'projeto_php_portal';
    public const DB_CHARSET = 'utf8mb4';
    public const DB_PORT = '3306';
    public const DB_COLLATE = 'utf8mb4_general_ci';


    public const DB_DSN = 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=' . self::DB_CHARSET . ';port=' . self::DB_PORT;
    public const DB_OPTIONS = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
    ];
    public const DB_CONNECTION = [
        'host' => self::DB_HOST,
        'user' => self::DB_USER,
        'password' => self::DB_PASS,
        'dbname' => self::DB_NAME,
        'charset' => self::DB_CHARSET,
        'port' => self::DB_PORT,
        'collate' => self::DB_COLLATE,
    ];

    public static function getBaseUri(): string
    {
        if (isset($_SERVER['CONTEXT_PREFIX'])) {
            return rtrim($_SERVER['CONTEXT_PREFIX'], '/');
        }

        return '';
    }
}
