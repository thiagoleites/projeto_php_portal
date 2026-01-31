<?php
declare(strict_types=1);

namespace Core\Exceptions;

use Throwable;

class TransactionException extends DatabaseException
{
    public function __construct(string $message = "", array $context = [], ?Throwable $previous = null)
    {
        parent::__construct(
            $message ?: "Erro durante a execução da transação",
            500,
            $context,
            $previous
        );
    }
}