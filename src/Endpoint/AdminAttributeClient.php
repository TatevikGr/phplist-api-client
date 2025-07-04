<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Entity\AdminAttributeDefinition;
use PhpList\RestApiClient\Entity\AdminAttributeValue;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;
use PhpList\RestApiClient\Request\Admin\CreateAdminAttributeDefinitionRequest;
use PhpList\RestApiClient\Request\Admin\UpdateAdminAttributeDefinitionRequest;
use PhpList\RestApiClient\Response\Admin\AdminAttributeDefinitionCollection;
use PhpList\RestApiClient\Response\Admin\AdminAttributeValueCollection;
use PhpList\RestApiClient\Response\DeleteResponse;

/**
 * Client for administrator-related API endpoints.
 */
class AdminAttributeClient
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
     * Get a list of administrator attribute definitions.
     *
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return AdminAttributeDefinitionCollection The list of attribute definitions
     * @throws ApiException If an API error occurs
     */
    public function getAttributeDefinitions(?int $afterId = null, int $limit = 25): AdminAttributeDefinitionCollection
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        $data = $this->client->get('administrators/attributes', $queryParams);
        return AdminAttributeDefinitionCollection::fromArray($data);
    }

    /**
     * Get an administrator attribute definition by ID.
     *
     * @param int $id The attribute definition ID
     * @return AdminAttributeDefinition The attribute definition data
     * @throws NotFoundException If the attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeDefinition(int $id): AdminAttributeDefinition
    {
        $data = $this->client->get("administrators/attributes/{$id}");
        return AdminAttributeDefinition::fromArray($data);
    }

    /**
     * Create a new administrator attribute definition.
     *
     * @param CreateAdminAttributeDefinitionRequest $request The attribute definition data
     * @return AdminAttributeDefinition The created attribute definition
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function createAttributeDefinition(CreateAdminAttributeDefinitionRequest $request): AdminAttributeDefinition
    {
        $data = $this->client->post('administrators/attributes', $request->toArray());
        return AdminAttributeDefinition::fromArray($data);
    }

    /**
     * Update an administrator attribute definition.
     *
     * @param int $id The attribute definition ID
     * @param UpdateAdminAttributeDefinitionRequest $request The attribute definition data
     * @return AdminAttributeDefinition The updated attribute definition
     * @throws NotFoundException If the attribute definition is not found
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function updateAttributeDefinition(int $id, UpdateAdminAttributeDefinitionRequest $request): AdminAttributeDefinition
    {
        $data = $this->client->put("administrators/attributes/{$id}", $request->toArray());
        return AdminAttributeDefinition::fromArray($data);
    }

    /**
     * Delete an administrator attribute definition.
     *
     * @param int $id The attribute definition ID
     * @return DeleteResponse The response data
     * @throws NotFoundException If the attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteAttributeDefinition(int $id): DeleteResponse
    {
        $data = $this->client->delete("administrators/attributes/{$id}");
        return DeleteResponse::fromArray($data);
    }

    /**
     * Get attribute values for an administrator.
     *
     * @param int $adminId The administrator ID
     * @return AdminAttributeValueCollection The attribute values
     * @throws NotFoundException If the administrator is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeValues(int $adminId): AdminAttributeValueCollection
    {
        $data = $this->client->get("administrators/attribute-values/{$adminId}");
        return AdminAttributeValueCollection::fromArray($data);
    }

    /**
     * Get a specific attribute value for an administrator.
     *
     * @param int $adminId The administrator ID
     * @param int $definitionId The attribute definition ID
     * @return AdminAttributeValue The attribute value
     * @throws NotFoundException If the administrator or attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeValue(int $adminId, int $definitionId): AdminAttributeValue
    {
        $data = $this->client->get("administrators/attribute-values/{$adminId}/{$definitionId}");
        return AdminAttributeValue::fromArray($data);
    }

    /**
     * Set a specific attribute value for an administrator.
     *
     * @param int $adminId The administrator ID
     * @param int $definitionId The attribute definition ID
     * @param string $value
     * @return AdminAttributeValue The updated attribute value
     * @throws ApiException If an API error occurs
     */
    public function setAttributeValue(int $adminId, int $definitionId, string $value): AdminAttributeValue
    {
        $data = $this->client->post("administrators/attribute-values/{$adminId}/{$definitionId}", [
            'value' => $value,
        ]);
        return AdminAttributeValue::fromArray($data);
    }

    /**
     * Delete a specific attribute value for an administrator.
     *
     * @param int $adminId The administrator ID
     * @param int $definitionId The attribute definition ID
     * @return DeleteResponse The response data
     * @throws NotFoundException If the administrator or attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteAttributeValue(int $adminId, int $definitionId): DeleteResponse
    {
        $data = $this->client->delete("administrators/attribute-values/{$adminId}/{$definitionId}");
        return DeleteResponse::fromArray($data);
    }
}
