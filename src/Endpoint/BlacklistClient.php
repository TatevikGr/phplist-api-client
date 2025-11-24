<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;

/**
 * Client for blacklist related API endpoints.
 */
class BlacklistClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Check if an email address is blacklisted.
     *
     * GET /api/v2/blacklist/check/{email}
     *
     * @param string $email Email address to check
     * @return array{blacklisted: bool, reason?: string|null}|array Raw API response
     * @throws ApiException If an API error occurs
     */
    public function check(string $email): array
    {
        return $this->client->get('blacklist/check/' . rawurlencode($email));
    }

    /**
     * Add an email address to the blacklist.
     *
     * POST /api/v2/blacklist/add
     *
     * @param string $email Email address to add
     * @param string|null $reason Optional reason
     * @return array{success?: bool, message?: string}|array Raw API response
     * @throws ApiException If an API error occurs
     */
    public function add(string $email, ?string $reason = null): array
    {
        $payload = ['email' => $email];
        if ($reason !== null) {
            $payload['reason'] = $reason;
        }
        return $this->client->post('blacklist/add', $payload);
    }

    /**
     * Remove an email address from the blacklist.
     *
     * DELETE /api/v2/blacklist/remove/{email}
     *
     * @param string $email Email address to remove
     * @return array{success?: bool, message?: string}|array Raw API response
     * @throws ApiException If an API error occurs
     */
    public function remove(string $email): array
    {
        return $this->client->delete('blacklist/remove/' . rawurlencode($email));
    }

    /**
     * Get information about a blacklisted email.
     *
     * GET /api/v2/blacklist/info/{email}
     *
     * @param string $email Email address to get info for
     * @return array{email?: string, added?: string|null, reason?: string|null}|array Raw API response
     * @throws ApiException If an API error occurs
     */
    public function info(string $email): array
    {
        return $this->client->get('blacklist/info/' . rawurlencode($email));
    }
}
