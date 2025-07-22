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

    protected function processItems(array $items): void
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->items[] = new Campaign($item);
        }
    }
}
