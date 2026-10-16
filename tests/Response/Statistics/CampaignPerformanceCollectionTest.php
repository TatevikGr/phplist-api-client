<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Response\Statistics;

use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Response\Statistics\CampaignPerformanceCollection;

class CampaignPerformanceCollectionTest extends TestCase
{
    public function testFromPlainListShape(): void
    {
        $data = [
            [
                'date' => '2026-03-19',
                'opens' => 234,
                'clicks' => 57,
            ],
            [
                'date' => null,
                'opens' => 0,
                'clicks' => 0,
            ],
        ];

        $response = new CampaignPerformanceCollection($data);

        $this->assertCount(2, $response->points);
        $this->assertSame('2026-03-19', $response->points[0]->date?->format('Y-m-d'));
        $this->assertSame(234, $response->points[0]->opens);
        $this->assertSame(57, $response->points[0]->clicks);
        $this->assertNull($response->points[1]->date);
    }

    public function testFromEmptyList(): void
    {
        $response = new CampaignPerformanceCollection([]);

        $this->assertSame([], $response->points);
    }
}
