<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests;

use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\ClientFactory;
use PhpList\RestApiClient\Endpoint\AdminClient;
use PhpList\RestApiClient\Endpoint\CampaignClient;
use PhpList\RestApiClient\Endpoint\AuthClient;
use PhpList\RestApiClient\Endpoint\StatisticsClient;
use PhpList\RestApiClient\Endpoint\SubscriptionClient;
use PhpList\RestApiClient\Endpoint\TemplatesClient;

class ClientFactoryTest extends TestCase
{
    private const BASE_URL = 'https://api.example.com';

    public function testCreateAllClients(): void
    {
        $clients = ClientFactory::createAllClients(self::BASE_URL);
        
        $this->assertIsArray($clients);
        $this->assertArrayHasKey('client', $clients);
        $this->assertArrayHasKey('admin', $clients);
        $this->assertArrayHasKey('campaign', $clients);
        $this->assertArrayHasKey('identity', $clients);
        $this->assertArrayHasKey('subscription', $clients);
        $this->assertArrayHasKey('statistics', $clients);
        $this->assertArrayHasKey('templates', $clients);
        
        $this->assertInstanceOf(Client::class, $clients['client']);
        $this->assertInstanceOf(AdminClient::class, $clients['admin']);
        $this->assertInstanceOf(CampaignClient::class, $clients['campaign']);
        $this->assertInstanceOf(AuthClient::class, $clients['identity']);
        $this->assertInstanceOf(SubscriptionClient::class, $clients['subscription']);
        $this->assertInstanceOf(StatisticsClient::class, $clients['statistics']);
        $this->assertInstanceOf(TemplatesClient::class, $clients['templates']);
    }
}
