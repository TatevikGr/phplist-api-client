<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Statistics;

use PhpList\RestApiClient\Entity\Statistics\DashboardMetric;

/**
 * Response class for the dashboard summary statistics.
 */
class DashboardSummaryResponse
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
