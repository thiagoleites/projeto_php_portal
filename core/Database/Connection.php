<?php

/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 *
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright © 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

declare(strict_types=1);

namespace Core\Database;

use Core\Helpers;
use Exception;
use mysqli;
use RuntimeException;

class Connection
{
    private static ?self $instance = null;
    // private static ?Connection $instance = null;
    /**
     * @var mysqli
     */
    private mysqli $connection;

    private function __construct()
    {
        $this->connection = new mysqli(
            Helpers::DB_HOST,
            Helpers::DB_USER,
            Helpers::DB_PASS,
            Helpers::DB_NAME
        );

        if ($this->connection->connect_error) {
            throw new RuntimeException("Falha na conexão: " . $this->connection->connect_error);
        }

        $this->connection->set_charset(Helpers::DB_CHARSET);
    }

    /**
     * Retorna uma instância única da classe Connection
     * 
     * @return self
     * @throws Exception
     * @throws \ErrorException
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Retorna a conexão com o banco de dados
     * 
     * @return mysqli
     * @throws Exception
     */
    public function getConnection(): mysqli
    {
        if ($this->connection === null) {
            throw new RuntimeException("Conexão com o banco de dados não estabelecida.");
        }
        return $this->connection;
    }


    /**
     * Fecha a conexão com o banco de dados
     * 
     * @return void
     * @throws Exception
     */
    public function close(): void
    {
        if ($this->connection) {
            $this->connection->close();
        }
        self::$instance = null;
    }

    /**
     * Previne a clonagem do objeto
     * 
     * @throws Exception
     * @return void
     */
    private function __clone() {}
}