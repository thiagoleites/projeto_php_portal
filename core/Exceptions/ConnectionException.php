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