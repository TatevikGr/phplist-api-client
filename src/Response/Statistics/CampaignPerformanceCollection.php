<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Statistics;

use PhpList\RestApiClient\Entity\Statistics\CampaignPerformancePoint;

/**
 * Response class for a collection of campaign performance chart points.
 */
class CampaignPerformanceCollection
{
    /**
     * @var CampaignPerformancePoint[] The list of campaign performance points
     */
    public array $points = [];

    public function __construct(array $data)
    {
        foreach ($data as $point) {
            $this->points[] = new CampaignPerformancePoint($point);
        }
    }
}
