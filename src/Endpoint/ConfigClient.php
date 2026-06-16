<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Entity\Config;
use PhpList\RestApiClient\Request\CreateConfigRequest;
use PhpList\RestApiClient\Response\ConfigCollection;

/**
 * Client for configuration-related API endpoints.
 */
class ConfigClient
{
    /**
     * @var Client The API client
     */
    private Client $client;

    /**
     * ConfigClient constructor.
     *
     * @param Client $client The API client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getConfigs(): ConfigCollection
    {
        $response = $this->client->get('configs');
        return new ConfigCollection($response);
    }

    public function getByKey(string $key): ?Config
    {
        $response = $this->client->get('configs/' . $key);
        return new Config($response);
    }

    public function delete(string $key): void
    {
        $this->client->delete('configs/' . $key);
    }

    public function create(CreateConfigRequest $request): ?Config
    {
        $response = $this->client->post('configs', $request->toArray());
        return new Config($response);
    }

    public function update(string $key, string $value): ?Config
    {
        $response = $this->client->put('configs/' . $key, ['value' => $value]);
        return new Config($response);
    }
}
