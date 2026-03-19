<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Statistics;

use PhpList\RestApiClient\Entity\Statistics\CampaignPerformancePoint;
use PhpList\RestApiClient\Entity\Statistics\DashboardMetric;
use PhpList\RestApiClient\Entity\Statistics\RecentCampaign;
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

    /**
     * @var RecentCampaign[]
     */
    public array $recentCampaigns = [];

    /**
     * @var CampaignPerformancePoint[]
     */
    public array $campaignPerformance = [];

    public function __construct(array $data)
    {
        $summaryStatistics = $data['summary_statistics'] ?? $data;

        $this->totalSubscribers = new DashboardMetric($summaryStatistics['total_subscribers'] ?? []);
        $this->activeCampaigns = new DashboardMetric($summaryStatistics['active_campaigns'] ?? []);
        $this->openRate = new DashboardMetric($summaryStatistics['open_rate'] ?? []);
        $this->bounceRate = new DashboardMetric($summaryStatistics['bounce_rate'] ?? []);

        foreach ($data['recent_campaigns'] ?? [] as $campaign) {
            $this->recentCampaigns[] = new RecentCampaign($campaign);
        }

        foreach ($data['campaign_performance'] ?? [] as $point) {
            $this->campaignPerformance[] = new CampaignPerformancePoint($point);
        }
    }
}
