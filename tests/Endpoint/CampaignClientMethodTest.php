<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\CampaignClient;
use PhpList\RestApiClient\Entity\Campaign;
use PhpList\RestApiClient\Request\Campaign\UpdateMessageDataRequest;
use PhpList\RestApiClient\Response\Campaign\StuckCampaignCollection;
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

    public function testResumeCampaign(): void
    {
        $campaignId = 321;

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('post')
            ->with('campaigns/' . $campaignId . '/resume')
            ->willReturn([
                'id' => $campaignId,
                'uniqueId' => 'campaign-unique-id',
            ]);

        $campaignClient = new CampaignClient($mockClient);
        $campaign = $campaignClient->resumeCampaign($campaignId);

        $this->assertInstanceOf(Campaign::class, $campaign);
        $this->assertSame($campaignId, $campaign->id);
    }

    public function testGetStuckCampaigns(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('campaigns/stuck')
            ->willReturn([
                [
                    'id' => 654,
                    'subject' => 'Stuck campaign',
                    'status' => 'inprocess',
                    'updated_at' => '2026-09-01T10:00:00+00:00',
                    'stuck_seconds' => 1845,
                ],
            ]);

        $campaignClient = new CampaignClient($mockClient);
        $stuckCampaigns = $campaignClient->getStuckCampaigns();

        $this->assertInstanceOf(StuckCampaignCollection::class, $stuckCampaigns);
        $this->assertCount(1, $stuckCampaigns->items);
        $this->assertSame(654, $stuckCampaigns->items[0]->id);
        $this->assertSame(1845, $stuckCampaigns->items[0]->stuckSeconds);
    }

    public function testUpdateMessageData(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('patch')
            ->with('campaigns/5/message-data', ['google_track' => true, 'exclude_lists' => [4, 5]])
            ->willReturn(['google_track' => true, 'utm_source' => null, 'exclude_lists' => [4, 5]]);

        $request = new UpdateMessageDataRequest();
        $request->googleTrack = true;
        $request->excludeLists = [4, 5];

        $result = (new CampaignClient($mockClient))->updateMessageData(5, $request);

        $this->assertTrue($result->googleTrack);
        $this->assertNull($result->utmSource);
        $this->assertSame([4, 5], $result->excludeLists);
    }
}
