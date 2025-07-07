<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Entity\Subscriber;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;
use PhpList\RestApiClient\Response\DeleteResponse;
use PhpList\RestApiClient\Response\Subscribers\SubscriberCollection;

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
     * @return SubscriberCollection The list of subscribers
     * @throws ApiException If an API error occurs
     */
    public function getSubscribers(?int $afterId = null, int $limit = 25): SubscriberCollection
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        $response = $this->client->get('subscribers', $queryParams);
        return new SubscriberCollection($response);
    }

    /**
     * Get a subscriber by ID.
     *
     * @param int $id The subscriber ID
     * @return Subscriber The subscriber data
     * @throws NotFoundException If the subscriber is not found
     * @throws ApiException If an API error occurs
     */
    public function getSubscriber(int $id): Subscriber
    {
        $response = $this->client->get("subscribers/{$id}");
        return new Subscriber($response);
    }

    /**
     * Create a new subscriber.
     *
     * @param array $data The subscriber data
     * @return Subscriber The created subscriber
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function createSubscriber(array $data): Subscriber
    {
        $response = $this->client->post('subscribers', $data);
        return new Subscriber($response);
    }

    /**
     * Update a subscriber.
     *
     * @param int $id The subscriber ID
     * @param array $data The subscriber data
     * @return Subscriber The updated subscriber
     * @throws NotFoundException If the subscriber is not found
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function updateSubscriber(int $id, array $data): Subscriber
    {
        $response = $this->client->put("subscribers/{$id}", $data);
        return new Subscriber($response);
    }

    /**
     * Delete a subscriber.
     *
     * @param int $id The subscriber ID
     * @return DeleteResponse The response data
     * @throws NotFoundException If the subscriber is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteSubscriber(int $id): DeleteResponse
    {
        $response = $this->client->delete("subscribers/{$id}");
        return new DeleteResponse($response);
    }
}
