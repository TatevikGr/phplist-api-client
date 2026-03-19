<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Response\Statistics;

use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Response\Statistics\DashboardStatisticsResponse;

class DashboardStatisticsResponseTest extends TestCase
{
    public function testFromOpenApiShape(): void
    {
        $data = [
            'summary_statistics' => [
                'total_subscribers' => [
                    'value' => 48294,
                    'change_vs_last_month' => 12.5,
                ],
                'active_campaigns' => [
                    'value' => 12,
                    'change_vs_last_month' => 0,
                ],
                'open_rate' => [
                    'value' => 42.5,
                    'change_vs_last_month' => -1.1,
                ],
                'bounce_rate' => [
                    'value' => 8.1,
                    'change_vs_last_month' => 0.2,
                ],
            ],
            'recent_campaigns' => [
                [
                    'name' => 'March Newsletter',
                    'status' => 'sent',
                    'date' => '2026-03-15',
                    'open_rate' => '42.50%',
                    'click_rate' => '8.10%',
                ],
                [
                    'name' => 'April Promo',
                    'status' => null,
                    'date' => null,
                    'open_rate' => '0%',
                    'click_rate' => '0%',
                ],
            ],
            'campaign_performance' => [
                [
                    'date' => '2026-03-19',
                    'opens' => 234,
                    'clicks' => 57,
                ],
            ],
        ];

        $response = new DashboardStatisticsResponse($data);

        $this->assertSame(48294, $response->totalSubscribers->value);
        $this->assertSame(12, $response->activeCampaigns->value);
        $this->assertSame(42.5, $response->openRate->value);
        $this->assertSame(8.1, $response->bounceRate->value);

        $this->assertCount(2, $response->recentCampaigns);
        $this->assertSame('March Newsletter', $response->recentCampaigns[0]->name);
        $this->assertSame('sent', $response->recentCampaigns[0]->status);
        $this->assertSame('2026-03-15', $response->recentCampaigns[0]->date?->format('Y-m-d'));
        $this->assertNull($response->recentCampaigns[1]->date);

        $this->assertCount(1, $response->campaignPerformance);
        $this->assertSame(234, $response->campaignPerformance[0]->opens);
        $this->assertSame(57, $response->campaignPerformance[0]->clicks);
        $this->assertSame('2026-03-19', $response->campaignPerformance[0]->date?->format('Y-m-d'));
    }

    public function testFromLegacyTopLevelShape(): void
    {
        $data = [
            'total_subscribers' => ['value' => 100],
            'active_campaigns' => ['value' => 2],
            'open_rate' => ['value' => 12.3],
            'bounce_rate' => ['value' => 0.2],
        ];

        $response = new DashboardStatisticsResponse($data);

        $this->assertSame(100, $response->totalSubscribers->value);
        $this->assertSame(2, $response->activeCampaigns->value);
        $this->assertSame(12.3, $response->openRate->value);
        $this->assertSame(0.2, $response->bounceRate->value);
        $this->assertSame([], $response->recentCampaigns);
        $this->assertSame([], $response->campaignPerformance);
    }
}
