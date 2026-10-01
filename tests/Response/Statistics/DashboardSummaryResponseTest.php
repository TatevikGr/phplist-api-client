<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Response\Statistics;

use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Response\Statistics\DashboardSummaryResponse;

class DashboardSummaryResponseTest extends TestCase
{
    public function testFromTopLevelShape(): void
    {
        $data = [
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
        ];

        $response = new DashboardSummaryResponse($data);

        $this->assertSame(48294, $response->totalSubscribers->value);
        $this->assertSame(12, $response->activeCampaigns->value);
        $this->assertSame(42.5, $response->openRate->value);
        $this->assertSame(8.1, $response->bounceRate->value);
        $this->assertSame(12.5, $response->totalSubscribers->changeVsLastMonth);
    }

    public function testWithMissingFieldsDefaultsToZero(): void
    {
        $response = new DashboardSummaryResponse([]);

        $this->assertSame(0, $response->totalSubscribers->value);
        $this->assertSame(0, $response->activeCampaigns->value);
        $this->assertSame(0, $response->openRate->value);
        $this->assertSame(0, $response->bounceRate->value);
    }
}
