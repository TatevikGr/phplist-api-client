<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;
use PhpList\RestApiClient\Request\Campaign\CreateCampaignRequest;
use PhpList\RestApiClient\Request\Campaign\UpdateCampaignRequest;

/**
 * Client for campaign-related API endpoints.
 */
class CampaignClient
{
    /**
     * @var Client The API client
     */
    private Client $client;

    /**
     * CampaignClient constructor.
     *
     * @param Client $client The API client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a list of campaigns.
     *
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return array The list of campaigns
     * @throws ApiException If an API error occurs
     */
    public function getCampaigns(?int $afterId = null, int $limit = 25): array
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        return $this->client->get('campaigns', $queryParams);
    }

    /**
     * Get a campaign by ID.
     *
     * @param int $id The campaign ID
     * @return array The campaign data
     * @throws NotFoundException If the campaign is not found
     * @throws ApiException If an API error occurs
     */
    public function getCampaign(int $id): array
    {
        return $this->client->get("campaigns/{$id}");
    }

    /**
     * Create a new campaign.
     *
     * @param CreateCampaignRequest $request The campaign data
     * @return array The created campaign
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function createCampaign(CreateCampaignRequest $request): array
    {
        return $this->client->post('campaigns', $request->toArray());
    }

    /**
     * Update a campaign.
     *
     * @param int $id The campaign ID
     * @param UpdateCampaignRequest $request The campaign data
     * @return array The updated campaign
     * @throws NotFoundException If the campaign is not found
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function updateCampaign(int $id, UpdateCampaignRequest $request): array
    {
        return $this->client->put("campaigns/{$id}", $request->toArray());
    }

    /**
     * Delete a campaign.
     *
     * @param int $id The campaign ID
     * @return array The response data
     * @throws NotFoundException If the campaign is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteCampaign(int $id): array
    {
        return $this->client->delete("campaigns/{$id}");
    }
}
