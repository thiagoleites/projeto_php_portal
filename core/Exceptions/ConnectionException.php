<?php
declare(strict_types=1);

namespace Core\Exceptions;

use Throwable;

class ConnectionException extends DatabaseException
{
   public function __construct(
        string $message = "", 
        array $context = [], 
        ?Throwable $previous = null
    ){
        parent::__construct(
            $message ?: "Falha na conexão com o banco de dados",
            500,
            $context,
            $previous
        );
   }
}