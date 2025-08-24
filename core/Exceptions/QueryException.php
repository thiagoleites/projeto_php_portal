<?php
/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 * File: DatabaseException.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types=1);

namespace Core\Exceptions;

use Throwable;

class QueryException extends DatabaseException
{
    public function __construct(string $message = "", string $query = "", array $context = [], ?Throwable $previous = null)
    {
        $context['query'] = $query;
        parent::__construct(
            $message ?: "Erro na execução da consulta SQL",
            500,
            $context,
            $previous
        );
    }
}