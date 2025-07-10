<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Entity\SubscriberAttributeDefinition;
use PhpList\RestApiClient\Entity\SubscriberAttributeValue;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Request\SubscriberAttribute\CreateSubscriberAttributeDefinitionRequest;
use PhpList\RestApiClient\Request\SubscriberAttribute\UpdateSubscriberAttributeDefinitionRequest;
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
        return new SubscriberAttributeCollection($response);
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
        $response = $this->client->get('subscribers/attributes/' . $id);
        return new SubscriberAttributeDefinition($response);
    }

    /**
     * Create a new subscriber attribute definition.
     *
     * @param CreateSubscriberAttributeDefinitionRequest $request
     * @return SubscriberAttributeDefinition The created attribute definition
     * @throws ApiException If an API error occurs
     */
    public function createAttributeDefinition(
        CreateSubscriberAttributeDefinitionRequest $request
    ): SubscriberAttributeDefinition {
        $response = $this->client->post('subscribers/attributes', $request->toArray());
        return new SubscriberAttributeDefinition($response);
    }

    /**
     * Update a subscriber attribute definition.
     *
     * @param int $id The attribute definition ID
     * @param UpdateSubscriberAttributeDefinitionRequest $request
     * @return SubscriberAttributeDefinition The updated attribute definition
     * @throws ApiException If an API error occurs
     */
    public function updateAttributeDefinition(
        int $id,
        UpdateSubscriberAttributeDefinitionRequest $request
    ): SubscriberAttributeDefinition {
        $response = $this->client->put('subscribers/attributes/' . $id, $request->toArray());
        return new SubscriberAttributeDefinition($response);
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
        $response = $this->client->delete('subscribers/attributes/' . $id);
        return new DeleteResponse($response);
    }

    /**
     * Get attribute values for a subscriber.
     *
     * @param int $subscriberId The subscriber ID
     * @return SubscriberAttributeValueCollection The attribute values
     * @throws NotFoundException If the subscriber is not found
     * @throws ApiException If an API error occurs
     */
    public function getAttributeValues(int $subscriberId, ?int $afterId = null): SubscriberAttributeValueCollection
    {
        $queryParams = [];
        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        $response = $this->client->get('subscribers/attribute-values/' . $subscriberId, $queryParams);
        return new SubscriberAttributeValueCollection($response);
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
        $response = $this->client->get('subscribers/attribute-values/' . $subscriberId . '/' . $definitionId);
        return new SubscriberAttributeValue($response);
    }

    /**
     * Set a specific attribute value for a subscriber.
     *
     * @param int $subscriberId The subscriber ID
     * @param int $definitionId The attribute definition ID
     * @param string|null $value
     * @return SubscriberAttributeValue The updated attribute value
     * @throws ApiException If an API error occurs
     */
    public function setAttributeValue(int $subscriberId, int $definitionId, ?string $value = null): SubscriberAttributeValue
    {
        $data = [];
        if ($value !== null) {
            $data['value'] = $value;
        }
        $response = $this->client->put('subscribers/attribute-values/' . $subscriberId . '/' . $definitionId, $data);
        return new SubscriberAttributeValue($response);
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
        $response = $this->client->delete('subscribers/attribute-values/' . $subscriberId . '/' . $definitionId);
        return new DeleteResponse($response);
    }
}
