<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Response\Statistics;

use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Response\Statistics\RecentCampaignsCollection;

class RecentCampaignsCollectionTest extends TestCase
{
    public function testFromPlainListShape(): void
    {
        $data = [
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
        ];

        $response = new RecentCampaignsCollection($data);

        $this->assertCount(2, $response->campaigns);
        $this->assertSame('March Newsletter', $response->campaigns[0]->name);
        $this->assertSame('sent', $response->campaigns[0]->status);
        $this->assertSame('2026-03-15', $response->campaigns[0]->date?->format('Y-m-d'));
        $this->assertNull($response->campaigns[1]->date);
        $this->assertNull($response->campaigns[1]->status);
    }

    public function testFromEmptyList(): void
    {
        $response = new RecentCampaignsCollection([]);

        $this->assertSame([], $response->campaigns);
    }
}
