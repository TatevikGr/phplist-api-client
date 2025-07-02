<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;

/**
 * Client for statistics and analytics-related API endpoints.
 */
class StatisticsClient
{
    /**
     * @var Client The API client
     */
    private Client $client;

    /**
     * StatisticsClient constructor.
     *
     * @param Client $client The API client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get campaign statistics.
     *
     * @return array The campaign statistics
     * @throws ApiException If an API error occurs
     * @throws NotFoundException If the campaign is not found
     */
    public function getCampaignStatistics(?int $afterId = null, int $limit = 25): array
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }
        return $this->client->get('analytics/campaigns', $queryParams);
    }


    /**
     * Get statistics for a specific time period.
     *
     * @param int|null $afterId
     * @param int $limit
     * @return array The time period statistics
     * @throws ApiException If an API error occurs
     */
    public function getStatisticsOfViewOpens(?int $afterId = null, int $limit = 25): array
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }
        return $this->client->get('statistics/view-opens', $queryParams);
    }
}
