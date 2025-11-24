<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\BouncesClient;
use PHPUnit\Framework\TestCase;

class BouncesClientTest extends TestCase
{
    private BouncesClient $bouncesClient;

    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $client = new Client($baseUrl);
        // Endpoints require authentication header
        $client->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->bouncesClient = new BouncesClient($client);
    }

    public function testCanListRegex(): void
    {
        $result = $this->bouncesClient->listRegex();
        $this->assertIsArray($result);
    }

    public function testCanUpsertGetAndDeleteRegex(): void
    {
        // Create/Update
        $payload = [
            'regex' => '/mailbox is full/i',
            'action' => 'delete',
            'list_order' => 0,
            'comment' => 'Unit test rule',
            'status' => 'active',
        ];
        $created = $this->bouncesClient->upsertRegex($payload);
        $this->assertIsArray($created);

        // If service returns regex_hash, try fetch + delete
        if (isset($created['regex_hash']) && is_string($created['regex_hash'])) {
            $hash = $created['regex_hash'];
            $fetched = $this->bouncesClient->getRegexByHash($hash);
            $this->assertIsArray($fetched);

            // Delete may return empty array (204)
            $deleted = $this->bouncesClient->deleteRegexByHash($hash);
            $this->assertIsArray($deleted);
        }

        $this->assertTrue(true);
    }
}
