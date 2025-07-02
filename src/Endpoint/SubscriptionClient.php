<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;

/**
 * Client for subscription-related API endpoints.
 */
class SubscriptionClient
{
    /**
     * @var Client The API client
     */
    private Client $client;

    /**
     * SubscriptionClient constructor.
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
     * Get a list of subscriber lists.
     *
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return array The list of subscriber lists
     * @throws ApiException If an API error occurs
     */
    public function getSubscriberLists(?int $afterId = null, int $limit = 25): array
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        return $this->client->get('lists', $queryParams);
    }

    /**
     * Get a subscriber list by ID.
     *
     * @param int $id The subscriber list ID
     * @return array The subscriber list data
     * @throws NotFoundException If the subscriber list is not found
     * @throws ApiException If an API error occurs
     */
    public function getSubscriberList(int $id): array
    {
        return $this->client->get("lists/{$id}");
    }

    /**
     * Create a new subscriber list.
     *
     * @param array $data The subscriber list data
     * @return array The created subscriber list
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function createSubscriberList(array $data): array
    {
        return $this->client->post('lists', $data);
    }

    /**
     * Update a subscriber list.
     *
     * @param int $id The subscriber list ID
     * @param array $data The subscriber list data
     * @return array The updated subscriber list
     * @throws NotFoundException If the subscriber list is not found
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function updateSubscriberList(int $id, array $data): array
    {
        return $this->client->put("lists/{$id}", $data);
    }

    /**
     * Delete a subscriber list.
     *
     * @param int $id The subscriber list ID
     * @return array The response data
     * @throws NotFoundException If the subscriber list is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteSubscriberList(int $id): array
    {
        return $this->client->delete("lists/{$id}");
    }

    /**
     * Add a subscriber to a list.
     *
     * @param int $subscriberId The subscriber ID
     * @param int $listId The list ID
     * @return array The response data
     * @throws NotFoundException If the subscriber or list is not found
     * @throws ApiException If an API error occurs
     */
    public function addSubscriberToList(int $subscriberId, int $listId): array
    {
        return $this->client->post("subscribers/{$subscriberId}/lists/{$listId}");
    }

    /**
     * Remove a subscriber from a list.
     *
     * @param int $subscriberId The subscriber ID
     * @param int $listId The list ID
     * @return array The response data
     * @throws NotFoundException If the subscriber or list is not found
     * @throws ApiException If an API error occurs
     */
    public function removeSubscriberFromList(int $subscriberId, int $listId): array
    {
        return $this->client->delete("subscribers/{$subscriberId}/lists/{$listId}");
    }

    /**
     * Get attribute values for a subscriber.
     *
     * @param int $subscriberId The subscriber ID
     * @return array The attribute values
     * @throws NotFoundException If the subscriber is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeValues(int $subscriberId): array
    {
        return $this->client->get("subscribers/attribute-values/{$subscriberId}");
    }

    /**
     * Get a specific attribute value for a subscriber.
     *
     * @param int $subscriberId The subscriber ID
     * @param int $definitionId The attribute definition ID
     * @return array The attribute value
     * @throws NotFoundException If the subscriber or attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeValue(int $subscriberId, int $definitionId): array
    {
        return $this->client->get("subscribers/attribute-values/{$subscriberId}/{$definitionId}");
    }

    /**
     * Set a specific attribute value for a subscriber.
     *
     * @param int $subscriberId The subscriber ID
     * @param int $definitionId The attribute definition ID
     * @param array $data The attribute value data
     * @return array The updated attribute value
     * @throws NotFoundException If the subscriber or attribute definition is not found
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function setAttributeValue(int $subscriberId, int $definitionId, array $data): array
    {
        return $this->client->put("subscribers/attribute-values/{$subscriberId}/{$definitionId}", $data);
    }

    /**
     * Delete a specific attribute value for a subscriber.
     *
     * @param int $subscriberId The subscriber ID
     * @param int $definitionId The attribute definition ID
     * @return array The response data
     * @throws NotFoundException If the subscriber or attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteAttributeValue(int $subscriberId, int $definitionId): array
    {
        return $this->client->delete("subscribers/attribute-values/{$subscriberId}/{$definitionId}");
    }

    /**
     * Export subscribers.
     *
     * @param array $filters Filters to apply to the export
     * @return array The export data
     * @throws ApiException If an API error occurs
     */
    public function exportSubscribers(array $filters = []): array
    {
        return $this->client->get('subscribers/export', $filters);
    }

    /**
     * Import subscribers.
     *
     * @param array $data The import data
     * @return array The import result
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function importSubscribers(array $data): array
    {
        return $this->client->post('subscribers/import', $data);
    }
}
