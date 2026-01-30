<?php
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