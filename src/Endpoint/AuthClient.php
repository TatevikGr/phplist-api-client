<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\AuthenticationException;

/**
 * Client for identity-related API endpoints.
 */
class AuthClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Login a user and get a session.
     *
     * @param string $username The username
     * @param string $password The password
     * @return array The session data
     * @throws AuthenticationException If authentication fails
     * @throws ApiException If an API error occurs
     */
    public function login(string $username, string $password): array
    {
        return $this->client->login($username, $password);
    }

    /**
     * Logout the current user.
     *
     * @return array The response data
     * @throws AuthenticationException If not authenticated or an API error occurs
     */
    public function logout(): array
    {
        $sessionId = $this->client->getSessionId();

        if (!$sessionId) {
            throw new AuthenticationException('Not authenticated');
        }
        $result = $this->client->delete('sessions/' . $sessionId);
        $this->client->setSessionId('');

        return $result;
    }
}
