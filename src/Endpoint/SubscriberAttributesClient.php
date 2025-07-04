<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Entity\SubscriberAttributeDefinition;
use PhpList\RestApiClient\Entity\SubscriberAttributeValue;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;
use PhpList\RestApiClient\Response\DeleteResponse;
use PhpList\RestApiClient\Response\SubscriberAttributes\SubscriberAttributeCollection;
use PhpList\RestApiClient\Response\SubscriberAttributes\SubscriberAttributeValueCollection;

/**
 * Client for subscriber attribute-related API endpoints.
 */
class SubscriberAttributesClient
{
    /**
     * @var Client The API client
     */
    private Client $client;

    /**
     * SubscriberAttributesClient constructor.
     *
     * @param Client $client The API client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a list of subscriber attribute definitions.
     *
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return SubscriberAttributeCollection The list of attribute definitions
     * @throws ApiException If an API error occurs
     */
    public function getAttributeDefinitions(?int $afterId = null, int $limit = 25): SubscriberAttributeCollection
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        $response = $this->client->get('subscribers/attributes', $queryParams);
        return SubscriberAttributeCollection::fromArray($response);
    }

    /**
     * Get a subscriber attribute definition by ID.
     *
     * @param int $id The attribute definition ID
     * @return SubscriberAttributeDefinition The attribute definition data
     * @throws NotFoundException If the attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeDefinition(int $id): SubscriberAttributeDefinition
    {
        $response = $this->client->get("subscribers/attributes/{$id}");
        return SubscriberAttributeDefinition::fromArray($response);
    }

    /**
     * Create a new subscriber attribute definition.
     *
     * @param array $data The attribute definition data
     * @return SubscriberAttributeDefinition The created attribute definition
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function createAttributeDefinition(array $data): SubscriberAttributeDefinition
    {
        $response = $this->client->post('subscribers/attributes', $data);
        return SubscriberAttributeDefinition::fromArray($response);
    }

    /**
     * Update a subscriber attribute definition.
     *
     * @param int $id The attribute definition ID
     * @param array $data The attribute definition data
     * @return SubscriberAttributeDefinition The updated attribute definition
     * @throws NotFoundException If the attribute definition is not found
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function updateAttributeDefinition(int $id, array $data): SubscriberAttributeDefinition
    {
        $response = $this->client->put("subscribers/attributes/{$id}", $data);
        return SubscriberAttributeDefinition::fromArray($response);
    }

    /**
     * Delete a subscriber attribute definition.
     *
     * @param int $id The attribute definition ID
     * @return DeleteResponse The response data
     * @throws NotFoundException If the attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteAttributeDefinition(int $id): DeleteResponse
    {
        $response = $this->client->delete("subscribers/attributes/{$id}");
        return DeleteResponse::fromArray($response);
    }

    /**
     * Get attribute values for a subscriber.
     *
     * @param int $subscriberId The subscriber ID
     * @return SubscriberAttributeValueCollection The attribute values
     * @throws NotFoundException If the subscriber is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeValues(int $subscriberId): SubscriberAttributeValueCollection
    {
        $response = $this->client->get("subscribers/attribute-values/{$subscriberId}");
        return SubscriberAttributeValueCollection::fromArray($response);
    }

    /**
     * Get a specific attribute value for a subscriber.
     *
     * @param int $subscriberId The subscriber ID
     * @param int $definitionId The attribute definition ID
     * @return SubscriberAttributeValue The attribute value
     * @throws NotFoundException If the subscriber or attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeValue(int $subscriberId, int $definitionId): SubscriberAttributeValue
    {
        $response = $this->client->get("subscribers/attribute-values/{$subscriberId}/{$definitionId}");
        return SubscriberAttributeValue::fromArray($response);
    }

    /**
     * Set a specific attribute value for a subscriber.
     *
     * @param int $subscriberId The subscriber ID
     * @param int $definitionId The attribute definition ID
     * @param array $data The attribute value data
     * @return SubscriberAttributeValue The updated attribute value
     * @throws NotFoundException If the subscriber or attribute definition is not found
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function setAttributeValue(int $subscriberId, int $definitionId, array $data): SubscriberAttributeValue
    {
        $response = $this->client->put("subscribers/attribute-values/{$subscriberId}/{$definitionId}", $data);
        return SubscriberAttributeValue::fromArray($response);
    }

    /**
     * Delete a specific attribute value for a subscriber.
     *
     * @param int $subscriberId The subscriber ID
     * @param int $definitionId The attribute definition ID
     * @return DeleteResponse The response data
     * @throws NotFoundException If the subscriber or attribute definition is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteAttributeValue(int $subscriberId, int $definitionId): DeleteResponse
    {
        $response = $this->client->delete("subscribers/attribute-values/{$subscriberId}/{$definitionId}");
        return DeleteResponse::fromArray($response);
    }
}
