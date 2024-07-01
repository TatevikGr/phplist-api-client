<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Exception;

/**
 * Exception thrown when a requested resource is not found.
 */
class NotFoundException extends ApiException
{
    /**
     * NotFoundException constructor.
     *
     * @param string $message The error message
     * @param int $statusCode The HTTP status code
     * @param \Throwable|null $previous The previous exception
     */
    public function __construct(string $message = 'Resource not found', int $statusCode = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);
    }
}
