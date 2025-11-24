<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Subscribers;

use Exception;
use PhpList\RestApiClient\Entity\SubscriberHistory;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a list of subscriber history items.
 */
class SubscriberHistoryCollection extends AbstractCollectionResponse
{
    /**
     * @var SubscriberHistory[] The list of subscriber history items
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
            $this->items[] = new SubscriberHistory($item);
        }
    }
}
