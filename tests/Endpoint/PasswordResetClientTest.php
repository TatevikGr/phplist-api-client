<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\PasswordResetClient;
use PHPUnit\Framework\TestCase;

class PasswordResetClientTest extends TestCase
{
    private PasswordResetClient $passwordResetClient;

    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $client = new Client($baseUrl);

        $this->passwordResetClient = new PasswordResetClient($client);
    }

    public function testCanRequestPasswordReset(): void
    {
        // Use a deterministic email; Prism mock should accept it
        $email = 'admin@example.com';
        $this->passwordResetClient->request($email);
        // If no exception thrown, consider success
        $this->assertTrue(true);
    }

    public function testCanValidateToken(): void
    {
        $token = 'a1b2c3d4e5f6';
        $result = $this->passwordResetClient->validate($token);
        $this->assertIsArray($result);
        // If mock provides 'valid', check it's a boolean
        if (array_key_exists('valid', $result)) {
            $this->assertIsBool($result['valid']);
        }
    }

    public function testCanResetPassword(): void
    {
        $token = 'a1b2c3d4e5f6';
        $newPassword = 'newSecurePassword123';
        $result = $this->passwordResetClient->reset($token, $newPassword);
        $this->assertIsArray($result);
        if (array_key_exists('message', $result)) {
            $this->assertIsString($result['message']);
        }
    }
}
