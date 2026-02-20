<?php
/**
 * ===============================================
 * TEMPORARY COMMIT MARKER
 * Branch: lint_tests
 * Date: 2026-02-18
 * Description: Temporary header for CI validation.
 * ===============================================
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