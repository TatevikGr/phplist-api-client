<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Campaign;

use PhpList\RestApiClient\Entity\Campaign\StuckCampaign;

/**
 * Response class for a list of campaigns stuck in processing.
 */
class StuckCampaignCollection
{
    /**
     * @var StuckCampaign[] The list of stuck campaigns
     */
    public array $items = [];

    public function __construct(array $data)
    {
        foreach ($data as $item) {
            $this->items[] = new StuckCampaign($item);
        }
    }
}
