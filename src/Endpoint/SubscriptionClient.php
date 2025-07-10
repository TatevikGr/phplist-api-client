<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use Exception;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Entity\SubscriberList;
use PhpList\RestApiClient\Entity\Subscription;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Request\CreateSubscriberListRequest;
use PhpList\RestApiClient\Response\DeleteResponse;
use PhpList\RestApiClient\Response\Subscribers\SubscriberCollection;
use PhpList\RestApiClient\Response\Subscribers\SubscriberListCollection;

/**
 * Client for subscription-related API endpoints.
 * @SuppressWarnings("TooManyPublicMethods")
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
     * Get a list of subscriber lists.
     *
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return SubscriberListCollection The list of subscriber lists
     * @throws ApiException If an API error occurs
     */
    public function getSubscriberLists(?int $afterId = null, int $limit = 25): SubscriberListCollection
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        $response = $this->client->get('lists', $queryParams);
        return new SubscriberListCollection($response);
    }

    /**
     * Get a subscriber list by ID.
     *
     * @param int $id The subscriber list ID
     * @return SubscriberList The subscriber list data
     * @throws ApiException If an API error occurs
     * @throws Exception
     */
    public function getSubscriberList(int $id): SubscriberList
    {
        $response = $this->client->get('lists/' . $id);
        return new SubscriberList($response);
    }

    /**
     * Create a new subscriber list.
     *
     * @param CreateSubscriberListRequest $request
     * @return SubscriberList The created subscriber list
     * @throws ApiException If an API error occurs
     * @throws Exception
     */
    public function createSubscriberList(CreateSubscriberListRequest $request): SubscriberList
    {
        return new SubscriberList($this->client->post('lists', $request->toArray()));
    }

    /**
     * Delete a subscriber list.
     *
     * @param int $id The subscriber list ID
     * @return DeleteResponse The response data
     * @throws NotFoundException If the subscriber list is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteSubscriberList(int $id): DeleteResponse
    {
        return new DeleteResponse($this->client->delete('lists/' . $id));
    }

    /**
     * Get total number of subscribers of a list
     * @throws ApiException
     */
    public function getSubscribersCountForList(int $id): array
    {
        return $this->client->get('lists/' . $id . '/count');
    }

    /**
     * Gets a paginated list of subscribers for a list
     *
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return SubscriberCollection The list of subscribers
     * @throws ApiException If an API error occurs
     */
    public function getSubscribersOfList(int $listId, ?int $afterId = null, int $limit = 25): SubscriberCollection
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        $response = $this->client->get('lists/' . $listId . '/subscribers', $queryParams);
        return new SubscriberCollection($response);
    }

    /**
     * Create subscription / add subscribers to list
     *
     * @param array $emails
     * @param int $listId
     * @return Subscription
     * @throws ApiException If an API error occurs
     * @throws Exception
     */
    public function createSubscription(array $emails, int $listId): Subscription
    {
        $response = $this->client->post('lists/' . $listId . '/subscribers', ['emails' => $emails]);
        return new Subscription($response);
    }

    /**
     * Delete subscription / remove subscribers from a list
     *
     * @param array $emails
     * @param int $listId
     * @return DeleteResponse
     * @throws ApiException If an API error occurs
     * @throws Exception
     */
    public function deleteSubscription(array $emails, int $listId): DeleteResponse
    {
        $response = $this->client->delete('lists/' . $listId . '/subscribers', ['emails' => $emails]);
        return new DeleteResponse($response);
    }
}
