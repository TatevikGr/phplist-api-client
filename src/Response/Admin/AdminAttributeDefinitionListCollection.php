<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Admin;

use PhpList\RestApiClient\Entity\AdminAttributeDefinition;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a list of administrator attribute definitions.
 */
class AdminAttributeDefinitionListCollection extends AbstractCollectionResponse
{
    /**
     * @var AdminAttributeDefinition[] The list of attribute definitions
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
            $this->items[] = AdminAttributeDefinition::fromArray($item);
        }
    }
}
