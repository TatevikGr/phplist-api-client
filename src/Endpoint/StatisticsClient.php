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
     * @param int|null $campaignId The campaign ID (optional)
     * @param array $filters Additional filters
     * @return array The campaign statistics
     * @throws ApiException If an API error occurs
     * @throws NotFoundException If the campaign is not found
     */
    public function getCampaignStatistics(?int $campaignId = null, array $filters = []): array
    {
        $endpoint = 'statistics/campaigns';
        
        if ($campaignId !== null) {
            $endpoint .= "/{$campaignId}";
        }
        
        return $this->client->get($endpoint, $filters);
    }

    /**
     * Get subscriber statistics.
     *
     * @param int|null $subscriberId The subscriber ID (optional)
     * @param array $filters Additional filters
     * @return array The subscriber statistics
     * @throws ApiException If an API error occurs
     * @throws NotFoundException If the subscriber is not found
     */
    public function getSubscriberStatistics(?int $subscriberId = null, array $filters = []): array
    {
        $endpoint = 'statistics/subscribers';
        
        if ($subscriberId !== null) {
            $endpoint .= "/{$subscriberId}";
        }
        
        return $this->client->get($endpoint, $filters);
    }

    /**
     * Get list statistics.
     *
     * @param int|null $listId The list ID (optional)
     * @param array $filters Additional filters
     * @return array The list statistics
     * @throws ApiException If an API error occurs
     * @throws NotFoundException If the list is not found
     */
    public function getListStatistics(?int $listId = null, array $filters = []): array
    {
        $endpoint = 'statistics/lists';
        
        if ($listId !== null) {
            $endpoint .= "/{$listId}";
        }
        
        return $this->client->get($endpoint, $filters);
    }

    /**
     * Get overall system statistics.
     *
     * @param array $filters Additional filters
     * @return array The system statistics
     * @throws ApiException If an API error occurs
     */
    public function getSystemStatistics(array $filters = []): array
    {
        return $this->client->get('statistics/system', $filters);
    }

    /**
     * Get statistics for a specific time period.
     *
     * @param string $startDate Start date in Y-m-d format
     * @param string $endDate End date in Y-m-d format
     * @param array $filters Additional filters
     * @return array The time period statistics
     * @throws ApiException If an API error occurs
     */
    public function getTimePeriodStatistics(string $startDate, string $endDate, array $filters = []): array
    {
        $filters['start_date'] = $startDate;
        $filters['end_date'] = $endDate;
        
        return $this->client->get('statistics/time-period', $filters);
    }
}
