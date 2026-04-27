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
    public function list(?int $afterId = null, int $limit = 25): BounceCollection
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }
        $response = $this->client->get('bounces', ['query' => $queryParams]);
        return new BounceCollection($response);
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
     * Get a bounce regex rule by its hash.
     *
     * GET /api/v2/bounces/regex/{regexHash}
     *
     * @param string $regexHash The regex hash
     * @return array The regex data
     * @throws ApiException If an API error occurs
     */
    public function getRegexByHash(string $regexHash): array
    {
        return $this->client->get('bounces/regex/' . rawurlencode($regexHash));
    }

    /**
     * Delete a bounce regex rule by its hash.
     *
     * DELETE /api/v2/bounces/regex/{regexHash}
     *
     * @param string $regexHash The regex hash
     * @return array Empty response on success
     * @throws ApiException If an API error occurs
     */
    public function deleteRegexByHash(string $regexHash): array
    {
        return $this->client->delete('bounces/regex/' . rawurlencode($regexHash));
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
