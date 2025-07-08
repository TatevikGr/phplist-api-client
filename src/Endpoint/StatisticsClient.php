<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Response\Statistics\CampaignStatisticsCollection;
use PhpList\RestApiClient\Response\Statistics\ViewOpensCollection;
use PhpList\RestApiClient\Response\Statistics\TopDomainsCollection;
use PhpList\RestApiClient\Response\Statistics\DomainConfirmationsCollection;
use PhpList\RestApiClient\Response\Statistics\TopLocalPartsCollection;

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
     * @return CampaignStatisticsCollection The campaign statistics
     * @throws ApiException If an API error occurs
     * @throws NotFoundException If the campaign is not found
     */
    public function getCampaignStatistics(?int $afterId = null, int $limit = 25): CampaignStatisticsCollection
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }
        $response = $this->client->get('analytics/campaigns', $queryParams);
        return new CampaignStatisticsCollection($response);
    }

    /**
     * Get statistics for a specific time period.
     *
     * @param int|null $afterId
     * @param int $limit
     * @return ViewOpensCollection The time period statistics
     * @throws ApiException If an API error occurs
     */
    public function getStatisticsOfViewOpens(?int $afterId = null, int $limit = 25): ViewOpensCollection
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }
        $response = $this->client->get('analytics/view-opens', $queryParams);
        return new ViewOpensCollection($response);
    }

    /**
     * Get top domains' statistics.
     *
     * @param int $limit Maximum number of domains to return
     * @param int $minSubscribers Minimum number of subscribers per domain
     * @return TopDomainsCollection The top domains statistics
     * @throws ApiException If an API error occurs
     */
    public function getTopDomains(int $limit = 20, int $minSubscribers = 5): TopDomainsCollection
    {
        $queryParams = [
            'limit' => $limit,
            'min_subscribers' => $minSubscribers
        ];

        $response = $this->client->get('analytics/domains/top', $queryParams);
        return new TopDomainsCollection($response);
    }

    /**
     * Get domain confirmation statistics.
     *
     * @param int $limit Maximum number of domains to return
     * @return DomainConfirmationsCollection The domain confirmation statistics
     * @throws ApiException If an API error occurs
     */
    public function getDomainConfirmationStatistics(int $limit = 50): DomainConfirmationsCollection
    {
        $queryParams = ['limit' => $limit];

        $response = $this->client->get('analytics/domains/confirmation', $queryParams);
        return new DomainConfirmationsCollection($response);
    }

    /**
     * Get top local-parts statistics.
     *
     * @param int $limit Maximum number of local-parts to return
     * @return TopLocalPartsCollection The top local-parts statistics
     * @throws ApiException If an API error occurs
     */
    public function getTopLocalParts(int $limit = 25): TopLocalPartsCollection
    {
        $queryParams = ['limit' => $limit];

        $response = $this->client->get('analytics/local-parts/top', $queryParams);
        return new TopLocalPartsCollection($response);
    }
}
