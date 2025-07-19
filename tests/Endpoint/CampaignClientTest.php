<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Exception\AuthenticationException;
use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\CampaignClient;
use PhpList\RestApiClient\Response\Campaign\CampaignCollection;
use PhpList\RestApiClient\Entity\Campaign;
use PhpList\RestApiClient\Request\Campaign\UpdateCampaignRequest;

class CampaignClientTest extends TestCase
{
    private CampaignClient $campaignClient;

    /**
     * @throws AuthenticationException
     */
    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $client = new Client($baseUrl);
        $client->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->campaignClient = new CampaignClient($client);
    }

    public function testCanFetchCampaigns(): void
    {
        $campaigns = $this->campaignClient->getCampaigns();
        $this->assertInstanceOf(CampaignCollection::class, $campaigns);
    }

    public function testCanFetchCampaignsWithPagination(): void
    {
        $campaigns = $this->campaignClient->getCampaigns(null, 10);
        $this->assertInstanceOf(CampaignCollection::class, $campaigns);
        $this->assertLessThanOrEqual(10, count($campaigns->items));
    }

    public function testCanFetchCampaign(): void
    {
        $campaigns = $this->campaignClient->getCampaigns();

        if (count($campaigns->items) > 0) {
            $campaignId = $campaigns->items[0]->id;
            $fetchedCampaign = $this->campaignClient->getCampaign($campaignId);
            $this->assertInstanceOf(Campaign::class, $fetchedCampaign);
            $this->assertEquals($campaignId, $fetchedCampaign->id);
        } else {
            $this->markTestSkipped('No campaigns available for testing');
        }
    }

    public function testCanUpdateCampaign(): void
    {
        $campaigns = $this->campaignClient->getCampaigns();

        if (count($campaigns->items) > 0) {
            $campaign = $campaigns->items[0];

            $updatedContent = [
                'subject' => 'Updated Test Campaign',
                'body' => 'This is an updated test campaign.',
                'footer' => 'This is an updated test campaign.',
                'text' => 'This is an updated test campaign.',
                'text_message' => 'This is an updated test campaign.',
            ];

            $format = [
                'html_formated' => false,
                'send_format' => 'html',
                'format_options' => ['text'],
            ];

            $metadata = [
                'title' => 'Updated Campaign Title',
                'description' => 'Updated campaign description'
            ];

            $schedule = [
                'embargo' => '2024-07-19T14:45:12+00:00',
            ];

            $options = [
                'track_opens' => true,
                'track_clicks' => true,
                'from_field' => 'Me <me@example.com>'
            ];

            $updateRequest = new UpdateCampaignRequest(
                $updatedContent,
                $format,
                $metadata,
                $schedule,
                $options
            );

            $updatedCampaign = $this->campaignClient->updateCampaign(
                $campaign->id,
                $updateRequest
            );

            $this->assertInstanceOf(Campaign::class, $updatedCampaign);
            $this->assertEquals($campaign->id, $updatedCampaign->id);

            $fetchedUpdatedCampaign = $this->campaignClient->getCampaign($campaign->id);
            $this->assertInstanceOf(Campaign::class, $fetchedUpdatedCampaign);

            if (isset($fetchedUpdatedCampaign->messageContent->subject)) {
                $this->assertEquals($updatedContent['subject'], $fetchedUpdatedCampaign->messageContent->subject);
            }

            if (isset($fetchedUpdatedCampaign->messageContent->body)) {
                $this->assertEquals($updatedContent['body'], $fetchedUpdatedCampaign->messageContent->body);
            }

            if (isset($fetchedUpdatedCampaign->metadata)) {
                if (isset($fetchedUpdatedCampaign->metadata->title)) {
                    $this->assertEquals($metadata['title'], $fetchedUpdatedCampaign->metadata->title);
                }
                if (isset($fetchedUpdatedCampaign->metadata->description)) {
                    $this->assertEquals($metadata['description'], $fetchedUpdatedCampaign->metadata->description);
                }
            }
        } else {
            $this->markTestSkipped('No campaigns available for testing');
        }
    }

    public function testCanDeleteCampaign(): void
    {
        $campaignId = 1;
        $this->campaignClient->deleteCampaign($campaignId);
        $this->assertTrue(true);
    }
}
