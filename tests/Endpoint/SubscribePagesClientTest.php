<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\SubscribePagesClient;
use PhpList\RestApiClient\Entity\SubscribePage;
use PhpList\RestApiClient\Request\SubscribePage\CreateSubscribePageRequest;
use PhpList\RestApiClient\Request\SubscribePage\UpdateSubscribePageRequest;
use PHPUnit\Framework\TestCase;

class SubscribePagesClientTest extends TestCase
{
    private SubscribePagesClient $client;

    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $api = new Client($baseUrl);
        $api->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->client = new SubscribePagesClient($api);
    }

    public function testCanCreateGetUpdateAndDeleteSubscribePage(): void
    {
        // Create
        $create = new CreateSubscribePageRequest(
            'Subscribe to our newsletter',
            true
        );
        $page = $this->client->createSubscribePage($create);
        $this->assertInstanceOf(SubscribePage::class, $page);
        $this->assertEquals($create->title, $page->title);

        // Get
        $fetched = $this->client->getSubscribePage($page->id);
        $this->assertInstanceOf(SubscribePage::class, $fetched);
        $this->assertEquals($page->id, $fetched->id);

        // Update
        $newTitle = 'Subscribe to our newsletter';
        $update = new UpdateSubscribePageRequest($newTitle, null);
        $updated = $this->client->updateSubscribePage($page->id, $update);
        $this->assertInstanceOf(SubscribePage::class, $updated);
        $this->assertEquals($newTitle, $updated->title);

        // Delete
        $this->client->deleteSubscribePage($page->id);
        $this->assertTrue(true);
    }
}
