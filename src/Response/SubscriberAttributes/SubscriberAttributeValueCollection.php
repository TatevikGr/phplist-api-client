<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\SubscriberAttributes;

use PhpList\RestApiClient\Entity\SubscriberAttributeValue;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a list of subscriber attribute values.
 */
class SubscriberAttributeValueCollection extends AbstractCollectionResponse
{
    /**
     * @var SubscriberAttributeValue[] The list of attribute values
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
            $this->items[] = new SubscriberAttributeValue($item);
        }
    }
}
