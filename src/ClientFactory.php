<?php

declare(strict_types=1);

namespace PhpList\RestApiClient;

use PhpList\RestApiClient\Endpoint\AdminClient;
use PhpList\RestApiClient\Endpoint\AdminAttributeClient;
use PhpList\RestApiClient\Endpoint\CampaignClient;
use PhpList\RestApiClient\Endpoint\AuthClient;
use PhpList\RestApiClient\Endpoint\StatisticsClient;
use PhpList\RestApiClient\Endpoint\SubscriberAttributesClient;
use PhpList\RestApiClient\Endpoint\SubscribersClient;
use PhpList\RestApiClient\Endpoint\SubscriptionClient;
use PhpList\RestApiClient\Endpoint\TemplatesClient;
use Psr\Log\LoggerInterface;

/**
 * Factory for creating API clients.
 */
class ClientFactory
{
    /**
     * Create a new API client.
     *
     * @param string $baseUrl The base URL for the API
     * @param array $config Additional configuration options for the HTTP client
     * @param LoggerInterface|null $logger Logger instance
     * @return Client The API client
     */
    public static function createClient(string $baseUrl, array $config = [], ?LoggerInterface $logger = null): Client
    {
        return new Client($baseUrl, $config, $logger);
    }

    /**
     * Create a new campaign client.
     *
     * @param Client $client The API client
     * @return CampaignClient The campaign client
     */
    public static function createCampaignClient(Client $client): CampaignClient
    {
        return new CampaignClient($client);
    }

    /**
     * Create a new identity client.
     *
     * @param Client $client The API client
     * @return AuthClient The identity client
     */
    public static function createIdentityClient(Client $client): AuthClient
    {
        return new AuthClient($client);
    }

    /**
     * Create a new subscription client.
     *
     * @param Client $client The API client
     * @return SubscriptionClient The subscription client
     */
    public static function createSubscriptionClient(Client $client): SubscriptionClient
    {
        return new SubscriptionClient($client);
    }

    /**
     * Create a new admin client.
     *
     * @param Client $client The API client
     * @return AdminClient The admin client
     */
    public static function createAdminClient(Client $client): AdminClient
    {
        return new AdminClient($client);
    }

    /**
     * Create a new admin client.
     *
     * @param Client $client The API client
     * @return AdminAttributeClient The admin client
     */
    public static function createAdminAttributeClient(Client $client): AdminAttributeClient
    {
        return new AdminAttributeClient($client);
    }

    /**
     * Create a new statistics client.
     *
     * @param Client $client The API client
     * @return StatisticsClient The statistics client
     */
    public static function createStatisticsClient(Client $client): StatisticsClient
    {
        return new StatisticsClient($client);
    }

    /**
     * Create a new templates client.
     *
     * @param Client $client The API client
     * @return TemplatesClient The templates client
     */
    public static function createTemplatesClient(Client $client): TemplatesClient
    {
        return new TemplatesClient($client);
    }

    /**
     * Create a new subscriber attributes client.
     *
     * @param Client $client The API client
     * @return SubscriberAttributesClient The subscriber attributes client
     */
    public static function createSubscriberAttributesClient(Client $client): SubscriberAttributesClient
    {
        return new SubscriberAttributesClient($client);
    }

    /**
     * Create a new subscribers' client.
     *
     * @param Client $client The API client
     * @return SubscribersClient The subscriber client
     */
    public static function createSubscribersClient(Client $client): SubscribersClient
    {
        return new SubscribersClient($client);
    }

    /**
     * Create all clients.
     *
     * @param string $baseUrl The base URL for the API
     * @param array $config Additional configuration options for the HTTP client
     * @param LoggerInterface|null $logger Logger instance
     * @return array An array containing all clients
     */
    public static function createAllClients(string $baseUrl, array $config = [], ?LoggerInterface $logger = null): array
    {
        $client = self::createClient($baseUrl, $config, $logger);

        return [
            'client' => $client,
            'admin' => self::createAdminClient($client),
            'admin_attributes' => self::createAdminAttributeClient($client),
            'campaign' => self::createCampaignClient($client),
            'identity' => self::createIdentityClient($client),
            'subscription' => self::createSubscriptionClient($client),
            'statistics' => self::createStatisticsClient($client),
            'templates' => self::createTemplatesClient($client),
            'subscriber_attributes' => self::createSubscriberAttributesClient($client),
            'subscribers' => self::createSubscribersClient($client),
        ];
    }
}
