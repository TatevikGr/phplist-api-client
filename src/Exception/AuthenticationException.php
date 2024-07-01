<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Exception;

/**
 * Exception thrown when authentication fails.
 */
class AuthenticationException extends ApiException
{
    /**
     * AuthenticationException constructor.
     *
     * @param string $message The error message
     * @param int $statusCode The HTTP status code
     * @param \Throwable|null $previous The previous exception
     */
    public function __construct(string $message = 'Authentication failed', int $statusCode = 401, \Throwable $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);
    }
}
