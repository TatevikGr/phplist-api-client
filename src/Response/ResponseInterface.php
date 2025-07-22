<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response;

/**
 * Interface for all API response classes.
 */
interface ResponseInterface
{
    /**
     * Convert the response to an array.
     *
     * @return array The response data as an array
     */
    public function toArray(): array;
}
