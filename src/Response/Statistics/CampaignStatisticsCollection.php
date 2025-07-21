<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Statistics;

use PhpList\RestApiClient\Entity\Statistics\CampaignStatistic;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a collection of campaign statistics.
 */
class CampaignStatisticsCollection extends AbstractCollectionResponse
{
    /**
     * @var CampaignStatistic[] The list of campaign statistics
     */
    public array $items = [];

    protected function processItems(array $items): void
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->items[] = new CampaignStatistic($item);
        }
    }
}
