<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Exception;

use Exception;
use Throwable;

/**
 * Base exception class for API errors.
 */
class ApiException extends Exception
{
    /**
     * @var int The HTTP status code
     */
    protected int $statusCode;

    /**
     * ApiException constructor.
     *
     * @param string $message The error message
     * @param int $statusCode The HTTP status code
     * @param Throwable|null $previous The previous exception
     */
    public function __construct(string $message = 'API error occurred', int $statusCode = 0, Throwable $previous = null)
    {
        $this->statusCode = $statusCode;
        parent::__construct($message, $statusCode, $previous);
    }

    /**
     * Get the HTTP status code.
     *
     * @return int The HTTP status code
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
