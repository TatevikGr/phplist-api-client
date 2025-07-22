<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\SubscriberAttributes;

use PhpList\RestApiClient\Entity\SubscriberAttributeDefinition;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a list of subscriber attribute definitions.
 */
class SubscriberAttributeCollection extends AbstractCollectionResponse
{
    /**
     * @var SubscriberAttributeDefinition[] The list of attribute definitions
     */
    public array $items = [];

    /**
     * Process the items in the collection.
     *
     * @param array $items The response data as an array
     */
    protected function processItems(array $items): void
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->items[] = new SubscriberAttributeDefinition($item);
        }
    }
}
