<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Entity\SubscriberList;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Request\CreateSubscriberListRequest;
use PhpList\RestApiClient\Response\Subscribers\SubscriberListCollection;

/**
 * Client for lists endpoints.
 */
class ListClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns a list of subscriber lists associated with admin or are public.
     *
     * GET /api/v2/lists/
     *
     * @throws ApiException
     */
    public function getLists(?int $afterId = null, int $limit = 25): SubscriberListCollection
    {
        $queryParams = ['limit' => $limit];
        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        $response = $this->client->get('/lists', $queryParams);
        return new SubscriberListCollection($response);
    }

    /**
     * Creates a subscriber list.
     *
     * POST /api/v2/lists
     *
     * @throws ApiException
     */
    public function createList(CreateSubscriberListRequest $request): SubscriberList
    {
        $response = $this->client->post('/lists', $request->toArray());
        return new SubscriberList($response);
    }

    /**
     * Returns a subscriber list by ID.
     *
     * GET /api/v2/lists/{listId}
     *
     * @throws ApiException
     */
    public function getList(int $listId): SubscriberList
    {
        $response = $this->client->get('/lists/' . $listId);
        return new SubscriberList($response);
    }

    /**
     * Deletes a subscriber list by ID.
     *
     * DELETE /api/v2/lists/{listId}
     *
     * @throws ApiException
     */
    public function deleteList(int $listId): void
    {
        $this->client->delete('/lists/' . $listId);
    }
}
