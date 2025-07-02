<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;

/**
 * Client for subscriber-related API endpoints.
 */
class SubscribersClient
{
    /**
     * @var Client The API client
     */
    private Client $client;

    /**
     * SubscribersClient constructor.
     *
     * @param Client $client The API client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a list of subscribers.
     *
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return array The list of subscribers
     * @throws ApiException If an API error occurs
     */
    public function getSubscribers(?int $afterId = null, int $limit = 25): array
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        return $this->client->get('subscribers', $queryParams);
    }

    /**
     * Get a subscriber by ID.
     *
     * @param int $id The subscriber ID
     * @return array The subscriber data
     * @throws NotFoundException If the subscriber is not found
     * @throws ApiException If an API error occurs
     */
    public function getSubscriber(int $id): array
    {
        return $this->client->get("subscribers/{$id}");
    }

    /**
     * Create a new subscriber.
     *
     * @param array $data The subscriber data
     * @return array The created subscriber
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function createSubscriber(array $data): array
    {
        return $this->client->post('subscribers', $data);
    }

    /**
     * Update a subscriber.
     *
     * @param int $id The subscriber ID
     * @param array $data The subscriber data
     * @return array The updated subscriber
     * @throws NotFoundException If the subscriber is not found
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function updateSubscriber(int $id, array $data): array
    {
        return $this->client->put("subscribers/{$id}", $data);
    }

    /**
     * Delete a subscriber.
     *
     * @param int $id The subscriber ID
     * @return array The response data
     * @throws NotFoundException If the subscriber is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteSubscriber(int $id): array
    {
        return $this->client->delete("subscribers/{$id}");
    }

    /**
     * Search for subscribers.
     *
     * @param string $query The search query
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return array The search results
     * @throws ApiException If an API error occurs
     */
    public function searchSubscribers(string $query, ?int $afterId = null, int $limit = 25): array
    {
        $queryParams = [
            'query' => $query,
            'limit' => $limit
        ];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        return $this->client->get('subscribers/search', $queryParams);
    }

    /**
     * Get subscriber history.
     *
     * @param int $id The subscriber ID
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return array The subscriber history
     * @throws NotFoundException If the subscriber is not found
     * @throws ApiException If an API error occurs
     */
    public function getSubscriberHistory(int $id, ?int $afterId = null, int $limit = 25): array
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        return $this->client->get("subscribers/{$id}/history", $queryParams);
    }
}
