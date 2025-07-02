<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request;

/**
 * Interface for all API request classes.
 */
interface RequestInterface
{
    /**
     * Convert the request to an array that can be passed to the API client.
     *
     * @return array The request data as an array
     */
    public function toArray(): array;
}
