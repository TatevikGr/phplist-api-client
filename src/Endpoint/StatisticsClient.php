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
        return $this->client->get('analytics/view-opens', $queryParams);
    }

    /**
     * Get top domains' statistics.
     *
     * @param int $limit Maximum number of domains to return
     * @param int $minSubscribers Minimum number of subscribers per domain
     * @return array The top domains statistics
     * @throws ApiException If an API error occurs
     */
    public function getTopDomains(int $limit = 20, int $minSubscribers = 5): array
    {
        $queryParams = [
            'limit' => $limit,
            'min_subscribers' => $minSubscribers
        ];

        return $this->client->get('analytics/domains/top', $queryParams);
    }

    /**
     * Get domain confirmation statistics.
     *
     * @param int $limit Maximum number of domains to return
     * @return array The domain confirmation statistics
     * @throws ApiException If an API error occurs
     */
    public function getDomainConfirmationStatistics(int $limit = 50): array
    {
        $queryParams = ['limit' => $limit];

        return $this->client->get('analytics/domains/confirmation', $queryParams);
    }

    /**
     * Get top local-parts statistics.
     *
     * @param int $limit Maximum number of local-parts to return
     * @return array The top local-parts statistics
     * @throws ApiException If an API error occurs
     */
    public function getTopLocalParts(int $limit = 25): array
    {
        $queryParams = ['limit' => $limit];

        return $this->client->get('analytics/local-parts/top', $queryParams);
    }
}
