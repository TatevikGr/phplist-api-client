<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response;

/**
 * Response class for delete operations.
 */
class DeleteResponse extends AbstractResponse
{
    /**
     * @var bool Whether the operation was successful
     */
    public bool $success = true;

    /**
     * @var string|null A message about the operation
     */
    public ?string $message = null;
}
