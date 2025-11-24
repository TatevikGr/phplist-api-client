<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;

/**
 * Client for password reset related API endpoints.
 */
class PasswordResetClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Request a password reset token for an administrator account.
     *
     * POST /api/v2/password-reset/request
     *
     * @param string $email Administrator email
     * @return void
     * @throws ApiException If an API error occurs
     */
    public function request(string $email): void
    {
        // Endpoint returns 204 No Content on success
        $this->client->post('password-reset/request', [
            'email' => $email,
        ]);
    }

    /**
     * Validate a password reset token.
     *
     * POST /api/v2/password-reset/validate
     *
     * @param string $token Password reset token
     * @return array{valid: bool}|array Generic response as returned by the API mock
     * @throws ApiException If an API error occurs
     */
    public function validate(string $token): array
    {
        return $this->client->post('password-reset/validate', [
            'token' => $token,
        ]);
    }

    /**
     * Reset an administrator password using a token.
     *
     * POST /api/v2/password-reset/reset
     *
     * @param string $token Password reset token
     * @param string $newPassword New password
     * @return array{message: string}|array Generic response as returned by the API mock
     * @throws ApiException If an API error occurs
     */
    public function reset(string $token, string $newPassword): array
    {
        return $this->client->post('password-reset/reset', [
            'token' => $token,
            'newPassword' => $newPassword,
        ]);
    }
}
