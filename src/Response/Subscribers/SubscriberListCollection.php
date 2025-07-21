<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Subscribers;

use Exception;
use PhpList\RestApiClient\Entity\SubscriberList;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a list of subscribers.
 */
class SubscriberListCollection extends AbstractCollectionResponse
{
    /**
     * @var SubscriberList[] The list of subscribers
     */
    public array $items = [];

    /**
     * Process the items in the collection.
     *
     * @param array $items The response data as an array
     * @throws Exception
     */
    protected function processItems(array $items): void
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->items[] = new SubscriberList($item);
        }
    }
}
