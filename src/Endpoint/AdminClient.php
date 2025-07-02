<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;
use PhpList\RestApiClient\Request\Admin\CreateAdministratorRequest;
use PhpList\RestApiClient\Request\Admin\UpdateAdministratorRequest;
use PhpList\RestApiClient\Request\Admin\CreateAdminAttributeDefinitionRequest;
use PhpList\RestApiClient\Request\Admin\UpdateAdminAttributeDefinitionRequest;
use PhpList\RestApiClient\Request\Admin\SetAdminAttributeValueRequest;

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

    /**
     * Get a list of administrator attribute definitions.
     *
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return array The list of attribute definitions
     * @throws ApiException If an API error occurs
     */
    public function getAttributeDefinitions(?int $afterId = null, int $limit = 25): array
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        return $this->client->get('administrators/attributes', $queryParams);
    }

    /**
     * Get an administrator attribute definition by ID.
     *
     * @param int $id The attribute definition ID
     * @return array The attribute definition data
     * @throws NotFoundException If the attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeDefinition(int $id): array
    {
        return $this->client->get("administrators/attributes/{$id}");
    }

    /**
     * Create a new administrator attribute definition.
     *
     * @param CreateAdminAttributeDefinitionRequest $request The attribute definition data
     * @return array The created attribute definition
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function createAttributeDefinition(CreateAdminAttributeDefinitionRequest $request): array
    {
        return $this->client->post('administrators/attributes', $request->toArray());
    }

    /**
     * Update an administrator attribute definition.
     *
     * @param int $id The attribute definition ID
     * @param UpdateAdminAttributeDefinitionRequest $request The attribute definition data
     * @return array The updated attribute definition
     * @throws NotFoundException If the attribute definition is not found
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function updateAttributeDefinition(int $id, UpdateAdminAttributeDefinitionRequest $request): array
    {
        return $this->client->put("administrators/attributes/{$id}", $request->toArray());
    }

    /**
     * Delete an administrator attribute definition.
     *
     * @param int $id The attribute definition ID
     * @return array The response data
     * @throws NotFoundException If the attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteAttributeDefinition(int $id): array
    {
        return $this->client->delete("administrators/attributes/{$id}");
    }

    /**
     * Get attribute values for an administrator.
     *
     * @param int $adminId The administrator ID
     * @return array The attribute values
     * @throws NotFoundException If the administrator is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeValues(int $adminId): array
    {
        return $this->client->get("administrators/attribute-values/{$adminId}");
    }

    /**
     * Get a specific attribute value for an administrator.
     *
     * @param int $adminId The administrator ID
     * @param int $definitionId The attribute definition ID
     * @return array The attribute value
     * @throws NotFoundException If the administrator or attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeValue(int $adminId, int $definitionId): array
    {
        return $this->client->get("administrators/attribute-values/{$adminId}/{$definitionId}");
    }

    /**
     * Set a specific attribute value for an administrator.
     *
     * @param int $adminId The administrator ID
     * @param int $definitionId The attribute definition ID
     * @param SetAdminAttributeValueRequest $request The attribute value data
     * @return array The updated attribute value
     * @throws NotFoundException If the administrator or attribute definition is not found
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function setAttributeValue(int $adminId, int $definitionId, SetAdminAttributeValueRequest $request): array
    {
        return $this->client->put("administrators/attribute-values/{$adminId}/{$definitionId}", $request->toArray());
    }

    /**
     * Delete a specific attribute value for an administrator.
     *
     * @param int $adminId The administrator ID
     * @param int $definitionId The attribute definition ID
     * @return array The response data
     * @throws NotFoundException If the administrator or attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteAttributeValue(int $adminId, int $definitionId): array
    {
        return $this->client->delete("administrators/attribute-values/{$adminId}/{$definitionId}");
    }
}
