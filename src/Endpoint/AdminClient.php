<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;
use PhpList\RestApiClient\Request\Admin\CreateAdministratorRequest;
use PhpList\RestApiClient\Request\Admin\UpdateAdministratorRequest;

/**
 * Client for administrator-related API endpoints.
 */
class AdminClient
{
    /**
     * @var Client The API client
     */
    private Client $client;

    /**
     * AdminClient constructor.
     *
     * @param Client $client The API client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a list of administrators.
     *
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return array The list of administrators
     * @throws ApiException If an API error occurs
     */
    public function getAdministrators(?int $afterId = null, int $limit = 25): array
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        return $this->client->get('administrators', $queryParams);
    }

    /**
     * Get an administrator by ID.
     *
     * @param int $id The administrator ID
     * @return array The administrator data
     * @throws NotFoundException If the administrator is not found
     * @throws ApiException If an API error occurs
     */
    public function getAdministrator(int $id): array
    {
        return $this->client->get("administrators/{$id}");
    }

    /**
     * Create a new administrator.
     *
     * @param CreateAdministratorRequest $request The administrator data
     * @return array The created administrator
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function createAdministrator(CreateAdministratorRequest $request): array
    {
        return $this->client->post('administrators', $request->toArray());
    }

    /**
     * Update an administrator.
     *
     * @param int $id The administrator ID
     * @param UpdateAdministratorRequest $request The administrator data
     * @return array The updated administrator
     * @throws NotFoundException If the administrator is not found
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function updateAdministrator(int $id, UpdateAdministratorRequest $request): array
    {
        return $this->client->put("administrators/{$id}", $request->toArray());
    }

    /**
     * Delete an administrator.
     *
     * @param int $id The administrator ID
     * @return array The response data
     * @throws NotFoundException If the administrator is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteAdministrator(int $id): array
    {
        return $this->client->delete("administrators/{$id}");
    }
}
