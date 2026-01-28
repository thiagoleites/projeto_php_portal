<?php
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