<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Campaign;

use PhpList\RestApiClient\Entity\Campaign;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a list of campaigns.
 */
class CampaignCollection extends AbstractCollectionResponse
{
    /**
     * @var Campaign[] The list of campaigns
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
            $this->items[] = Campaign::fromArray($item);
        }
    }
}
