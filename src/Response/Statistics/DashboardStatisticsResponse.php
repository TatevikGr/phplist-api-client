<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Statistics;

use PhpList\RestApiClient\Entity\Statistics\DashboardMetric;
use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Response class for dashboard analytics statistics.
 */
class DashboardStatisticsResponse extends AbstractResponse
{
    public DashboardMetric $totalSubscribers;

    public DashboardMetric $activeCampaigns;

    public DashboardMetric $openRate;

    public DashboardMetric $bounceRate;

    public function __construct(array $data)
    {
        $this->totalSubscribers = new DashboardMetric($data['total_subscribers'] ?? []);
        $this->activeCampaigns = new DashboardMetric($data['active_campaigns'] ?? []);
        $this->openRate = new DashboardMetric($data['open_rate'] ?? []);
        $this->bounceRate = new DashboardMetric($data['bounce_rate'] ?? []);
    }
}
