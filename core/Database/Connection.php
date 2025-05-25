<?php

declare(strict_types=1);

namespace Core\Database;

use Exception;
use mysqli;

class Connection
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $this->connection = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME
        );

        if ($this->connection->connect_error) {
            throw new Exception("Falha na conexão: " . $this->connection->connect_error);
        }
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
        if (!self::$instance) {
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
        return $this->connection;
    }


    /**
     * Fecha a conexão com o banco de dados
     * 
     * @return void
     * @throws Exception
     */
    public function close()
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