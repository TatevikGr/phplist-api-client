<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Statistics;

use PhpList\RestApiClient\Entity\Statistics\RecentCampaign;

/**
 * Response class for a collection of recent campaigns.
 */
class RecentCampaignsCollection
{
    /**
     * @var RecentCampaign[] The list of recent campaigns
     */
    public array $campaigns = [];

    public function __construct(array $data)
    {
        foreach ($data as $campaign) {
            $this->campaigns[] = new RecentCampaign($campaign);
        }
    }
}
