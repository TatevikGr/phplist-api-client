<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Exception;

/**
 * Exception thrown when validation fails for API requests.
 */
class ValidationException extends ApiException
{
    /**
     * @var array The validation errors
     */
    private array $errors;

    /**
     * ValidationException constructor.
     *
     * @param string $message The error message
     * @param int $statusCode The HTTP status code
     * @param array $errors The validation errors
     * @param \Throwable|null $previous The previous exception
     */
    public function __construct(
        string $message = 'Validation failed',
        int $statusCode = 422,
        array $errors = [],
        \Throwable $previous = null
    ) {
        $this->errors = $errors;
        parent::__construct($message, $statusCode, $previous);
    }

    /**
     * Get the validation errors.
     *
     * @return array The validation errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Check if there are validation errors for a specific field.
     *
     * @param string $field The field name
     * @return bool True if there are errors for the field
     */
    public function hasErrorsForField(string $field): bool
    {
        return isset($this->errors[$field]);
    }

    /**
     * Get the validation errors for a specific field.
     *
     * @param string $field The field name
     * @return array The validation errors for the field
     */
    public function getErrorsForField(string $field): array
    {
        return $this->errors[$field] ?? [];
    }
}
