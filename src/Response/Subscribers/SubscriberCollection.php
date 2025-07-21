<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Subscribers;

use PhpList\RestApiClient\Entity\Subscriber;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a list of subscribers.
 */
class SubscriberCollection extends AbstractCollectionResponse
{
    /**
     * @var Subscriber[] The list of subscribers
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
            $this->items[] = new Subscriber($item);
        }
    }
}
