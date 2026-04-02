<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\CampaignClient;
use PhpList\RestApiClient\Entity\Campaign;
use PHPUnit\Framework\TestCase;

class CampaignClientMethodTest extends TestCase
{
    public function testUpdateCampaignStatus(): void
    {
        $campaignId = 123;
        $status = 'draft';

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('patch')
            ->with('campaigns/' . $campaignId, ['status' => $status])
            ->willReturn([
                'id' => $campaignId,
                'uniqueId' => 'campaign-unique-id',
            ]);

        $campaignClient = new CampaignClient($mockClient);
        $campaign = $campaignClient->updateCampaignStatus($campaignId, $status);

        $this->assertInstanceOf(Campaign::class, $campaign);
        $this->assertSame($campaignId, $campaign->id);
    }

    public function testCopyCampaign(): void
    {
        $campaignId = 456;
        $copiedCampaignId = 789;

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('post')
            ->with('campaigns/' . $campaignId)
            ->willReturn([
                'id' => $copiedCampaignId,
                'uniqueId' => 'copied-campaign-unique-id',
            ]);

        $campaignClient = new CampaignClient($mockClient);
        $campaign = $campaignClient->copyCampaign($campaignId);

        $this->assertInstanceOf(Campaign::class, $campaign);
        $this->assertSame($copiedCampaignId, $campaign->id);
    }
}
