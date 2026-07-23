<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\ConfigClient;
use PhpList\RestApiClient\Entity\Config;
use PhpList\RestApiClient\Request\CreateConfigRequest;
use PhpList\RestApiClient\Response\ConfigCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfigClientTest extends TestCase
{
    private Client&MockObject $client;
    private ConfigClient $configClient;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->configClient = new ConfigClient($this->client);
    }

    public function testGetConfigsReturnsConfigCollection(): void
    {
        $response = ['items' => []];

        $this->client->expects($this->once())
            ->method('get')
            ->with('configs')
            ->willReturn($response);

        $result = $this->configClient->getConfigs();

        $this->assertInstanceOf(ConfigCollection::class, $result);
    }

    public function testGetByKeyReturnsConfig(): void
    {
        $key = 'site_name';
        $response = ['key' => $key, 'value' => 'phpList'];

        $this->client->expects($this->once())
            ->method('get')
            ->with('configs/' . $key)
            ->willReturn($response);

        $result = $this->configClient->getByKey($key);

        $this->assertInstanceOf(Config::class, $result);
    }

    public function testDeleteCallsClientDelete(): void
    {
        $key = 'site_name';

        $this->client->expects($this->once())
            ->method('delete')
            ->with('configs/' . $key);

        $this->configClient->delete($key);
    }

    public function testCreateReturnsConfig(): void
    {
        $requestData = ['key' => 'site_name', 'value' => 'phpList'];
        $response = $requestData;

        $request = $this->createMock(CreateConfigRequest::class);
        $request->expects($this->once())
            ->method('toArray')
            ->willReturn($requestData);

        $this->client->expects($this->once())
            ->method('post')
            ->with('configs', $requestData)
            ->willReturn($response);

        $result = $this->configClient->create($request);

        $this->assertInstanceOf(Config::class, $result);
    }

    public function testUpdateReturnsConfig(): void
    {
        $key = 'site_name';
        $value = 'New Name';
        $response = ['key' => $key, 'value' => $value];

        $this->client->expects($this->once())
            ->method('put')
            ->with('configs/' . $key, ['value' => $value])
            ->willReturn($response);

        $result = $this->configClient->update($key, $value);

        $this->assertInstanceOf(Config::class, $result);
    }
}
