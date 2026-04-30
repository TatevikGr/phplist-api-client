<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Response\Bounces\BounceCollection;

/**
 * Client for bounce-related API endpoints.
 */
class BouncesClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a list of all bounce regex rules.
     *
     * GET /api/v2/bounces/regex
     *
     * @return array<int, array>|array Raw API response
     * @throws ApiException If an API error occurs
     */
    public function listRegex(): array
    {
        return $this->client->get('bounces/regex');
    }

    /**
     * Get a list of all bounces.
     *
     * GET /api/v2/bounces
     *
     * @return BounceCollection
     * @throws ApiException If an API error occurs
     */
    public function list(?int $afterId = null, ?int $limit = 25, ?string $status = null): BounceCollection
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }
        if ($status !== null) {
            $queryParams['status'] = $status;
        }
        $response = $this->client->get('bounces', ['query' => $queryParams]);
        return new BounceCollection($response);
    }

    /**
     * Get a list of bounce counts by campaign.
     *
     * GET /api/v2/bounces/by/campaign
     *
     * @return array<int, array{
     *     message_id: int,
     *     subject: string,
     *     total_bounces: int
     * }> Raw API response
     * @throws ApiException If an API error occurs
     */
    public function listByCampaign(): array
    {
        return $this->client->get('bounces/by/campaign');
    }

    /**
     * Get a list of bounce counts by subscriber.
     *
     * GET /api/v2/bounces/by/subscriber
     *
     * @return array<int, array{
     *     subscriber_id: int,
     *     email: string,
     *     confirmed: bool,
     *     blacklisted: bool,
     *     total_bounces: int
     * }> Raw API response
     * @throws ApiException If an API error occurs
     */
    public function listBySubscriber(): array
    {
        return $this->client->get('bounces/by/subscriber');
    }

    /**
     * Create or update a bounce regex rule.
     *
     * POST /api/v2/bounces/regex
     *
     * @param array $data Keys: regex (required), action?, list_order?, admin?, comment?, status?
     * @return array The created/updated regex data
     * @throws ApiException If an API error occurs
     */
    public function upsertRegex(array $data): array
    {
        return $this->client->post('bounces/regex', $data);
    }

    /**
     * Get a bounce regex rule by its id.
     *
     * GET /api/v2/bounces/regex/{ruleId}
     *
     * @param int $ruleId The regex id
     * @return array The regex data
     * @throws ApiException If an API error occurs
     */
    public function getOne(int $ruleId): array
    {
        return $this->client->get('bounces/regex/' . $ruleId);
    }

    /**
     * Delete a bounce regex rule by its id.
     *
     * DELETE /api/v2/bounces/regex/{ruleId}
     *
     * @param int $ruleId The regex id
     * @return array Empty response on success
     * @throws ApiException If an API error occurs
     */
    public function delete(int $ruleId): array
    {
        return $this->client->delete('bounces/regex/' . $ruleId);
    }

    /**
     * Delete a bounce by its id.
     *
     * DELETE /api/v2/bounces/{bounceId}
     *
     * @param string $bounceId The bounce id
     * @return array Empty response on success
     * @throws ApiException If an API error occurs
     */
    public function deleteById(string $bounceId): array
    {
        return $this->client->delete('bounces/' . rawurlencode($bounceId));
    }
}
