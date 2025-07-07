<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Admin;

use PhpList\RestApiClient\Entity\AdminAttributeValue;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a list of administrator attribute values.
 */
class AdminAttributeValueCollection extends AbstractCollectionResponse
{
    /**
     * @var AdminAttributeValue[] The list of attribute values
     */
    public array $items = [];

    /**
     * Process the items in the collection.
     *
     * @param array $data The response data as an array
     */
    protected function processItems(array $data): void
    {
        $this->items = [];
        foreach ($data['items'] ?? $data as $item) {
            $this->items[] = new AdminAttributeValue($item);
        }
    }
}
