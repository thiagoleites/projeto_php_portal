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

class DatabaseOperationException extends RuntimeException
{
    private string $query;
    private array $params;

    public function __construct(
        string $message,
        string $query = '',
        array $params = [],
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->query = $query;
        $this->params = $params;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getParams(): array
    {
        return $this->params;
    }

}