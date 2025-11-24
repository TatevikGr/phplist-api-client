<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Entity\SubscribePage;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Request\SubscribePage\CreateSubscribePageRequest;
use PhpList\RestApiClient\Request\SubscribePage\UpdateSubscribePageRequest;

/**
 * Client for subscribe page-related API endpoints.
 */
class SubscribePagesClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a subscribe page by ID.
     *
     * @throws NotFoundException|ApiException
     */
    public function getSubscribePage(int $id): SubscribePage
    {
        $data = $this->client->get('subscribe-pages/' . $id);
        return new SubscribePage($data);
    }

    /**
     * Create a new subscribe page.
     *
     * @throws ApiException
     */
    public function createSubscribePage(CreateSubscribePageRequest $request): SubscribePage
    {
        $data = $this->client->post('subscribe-pages', $request->toArray());
        return new SubscribePage($data);
    }

    /**
     * Update a subscribe page by ID.
     *
     * @throws NotFoundException|ApiException
     */
    public function updateSubscribePage(int $id, UpdateSubscribePageRequest $request): SubscribePage
    {
        $data = $this->client->put('subscribe-pages/' . $id, $request->toArray());
        return new SubscribePage($data);
    }

    /**
     * Delete a subscribe page by ID.
     *
     * @throws NotFoundException|ApiException
     */
    public function deleteSubscribePage(int $id): void
    {
        $this->client->delete('subscribe-pages/' . $id);
    }
}
