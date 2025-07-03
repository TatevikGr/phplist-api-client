<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response;

/**
 * Interface for all API response classes.
 */
interface ResponseInterface
{
    /**
     * Create a response object from an array of data returned by the API.
     *
     * @param array $data The response data as an array
     * @return static The response object
     */
    public static function fromArray(array $data): self;

    /**
     * Convert the response to an array.
     *
     * @return array The response data as an array
     */
    public function toArray(): array;
}
