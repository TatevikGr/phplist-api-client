<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Response;

use PhpList\RestApiClient\Response\AbstractCollectionResponse;

class TestCollectionResponse extends AbstractCollectionResponse
{
    /**
     * @var array The list of items in the collection
     */
    public array $items = [];

    /**
     * Process the items in the collection.
     *
     * @param array $data The response data as an array
     */
    protected function processItems(array $data): void
    {
        $this->items = $data['items'] ?? $data;
    }
}
