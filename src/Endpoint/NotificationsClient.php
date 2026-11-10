<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Response\AdminNotificationCollection;

/**
 * Client for notification-related API endpoints.
 */
class NotificationsClient
{
    /**
     * @var Client The API client
     */
    private Client $client;

    /**
     * NotificationsClient constructor.
     *
     * @param Client $client The API client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the in-app notifications of the authenticated administrator.
     *
     * @return AdminNotificationCollection The list of notifications
     * @throws ApiException If an API error occurs
     */
    public function getNotifications(): AdminNotificationCollection
    {
        $response = $this->client->get('notifications');
        return new AdminNotificationCollection($response);
    }
}
