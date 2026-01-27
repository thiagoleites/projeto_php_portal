<?php
declare(strict_types=1);

namespace Core\Exceptions;

use RuntimeException;
use Throwable;

class DatabaseException extends RuntimeException
{
    protected $context = [];

    public function __construct(string $message = "", int $code = 0, array $context = [], ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function toArray(): array
    {
        return [
            'error' => [
                'type' => static::class,
                'message' => $this->getMessage(),
                'code' => $this->getCode(),
                'context' => $this->getContext(),
                'trace' => $this->getTrace(),
            ]
        ];
    }
}