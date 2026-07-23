<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\AuthClient;
use PhpList\RestApiClient\Endpoint\ConfigClient;
use PhpList\RestApiClient\Entity\Config;
use PhpList\RestApiClient\Request\CreateConfigRequest;
use PhpList\RestApiClient\Response\ConfigCollection;
use PHPUnit\Framework\TestCase;

class ConfigClientIntegrationTest extends TestCase
{
    private Client $client;
    private AuthClient $authClient;
    private ConfigClient $configClient;

    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $this->client = new Client($baseUrl);
        $this->authClient = new AuthClient($this->client);
        $this->configClient = new ConfigClient($this->client);

        $username = getenv('API_USERNAME');
        $password = getenv('API_PASSWORD');

        $this->authClient->login($username, $password);
    }

    protected function tearDown(): void
    {
        if ($this->client->getSessionId()) {
            $this->authClient->logout();
        }
    }

    public function testCanGetConfigs(): void
    {
        $configs = $this->configClient->getConfigs();

        $this->assertInstanceOf(ConfigCollection::class, $configs);
    }

    public function testCanGetConfigByKey(): void
    {
        $config = $this->configClient->getByKey('organisation_name');

        $this->assertInstanceOf(Config::class, $config);
        $this->assertEquals('organisation_name', $config->key);
    }

    public function testCanCreateConfig(): void
    {
        $request = new CreateConfigRequest('organisation_name', 'Example Organisation');

        $config = $this->configClient->create($request);

        $this->assertInstanceOf(Config::class, $config);
        $this->assertEquals('organisation_name', $config->key);
        $this->assertEquals('Example Organisation', $config->value);
    }

    public function testCanUpdateConfig(): void
    {
        $request = new CreateConfigRequest('organisation_name', 'initial_value');
        $this->configClient->create($request);

        $updated = $this->configClient->update('organisation_name', 'Example Organisation');

        $this->assertInstanceOf(Config::class, $updated);
        $this->assertEquals('organisation_name', $updated->key);
        $this->assertEquals('Example Organisation', $updated->value);
    }

    public function testCanDeleteConfig(): void
    {
        $request = new CreateConfigRequest('test_key', 'test_value');
        $this->configClient->create($request);

        $this->configClient->delete('test_key');

        $this->addToAssertionCount(1);
    }
}
