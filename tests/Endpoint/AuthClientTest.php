<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Exception\AuthenticationException;
use PhpList\RestApiClient\Entity\Administrator;
use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\AuthClient;

class AuthClientTest extends TestCase
{
    private AuthClient $authClient;
    private Client $client;
    private string $username;
    private string $password;

    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $this->client = new Client($baseUrl);
        $this->authClient = new AuthClient($this->client);

        $this->username = getenv('API_USERNAME');
        $this->password = getenv('API_PASSWORD');
    }

    public function testCanLogin(): void
    {
        $sessionData = $this->authClient->login($this->username, $this->password);

        $this->assertIsArray($sessionData);
        $this->assertArrayHasKey('key', $sessionData);
        $this->assertNotEmpty($sessionData['key']);

        $this->assertNotNull($this->client->getSessionId());
        $this->assertEquals($sessionData['key'], $this->client->getSessionId());
    }

    public function testCanLogout(): void
    {
        $this->authClient->login($this->username, $this->password);

        $this->assertNotNull($this->client->getSessionId());

        $logoutResponse = $this->authClient->logout();

        $this->assertIsArray($logoutResponse);
        $this->assertEmpty($this->client->getSessionId());
        $this->assertTrue(true);
    }

    public function testLogoutFailsWhenNotAuthenticated(): void
    {
        $this->client->setSessionId('');

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Not authenticated');

        $this->authClient->logout();
    }

    public function testCanGetSessionUser(): void
    {
        $mockClient = $this->createMock(Client::class);
        $adminData = [
            'id' => 1,
            'login_name' => 'admin',
            'email' => 'admin@example.com',
            'super_user' => true,
            'created_at' => '2023-01-01 00:00:00',
        ];

        $mockClient->expects($this->once())
            ->method('getSessionId')
            ->willReturn('valid-session-id');

        $mockClient->expects($this->once())
            ->method('get')
            ->with('sessions/me')
            ->willReturn($adminData);

        $authClient = new AuthClient($mockClient);
        $admin = $authClient->getSessionUser();

        $this->assertInstanceOf(Administrator::class, $admin);
        $this->assertEquals(1, $admin->id);
        $this->assertEquals('admin', $admin->loginName);
        $this->assertEquals('admin@example.com', $admin->email);
        $this->assertTrue($admin->superUser);
        $this->assertEquals('2023-01-01 00:00:00', $admin->createdAt->format('Y-m-d H:i:s'));
    }

    public function testGetSessionUserFailsWhenNotAuthenticated(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('getSessionId')
            ->willReturn(null);

        $authClient = new AuthClient($mockClient);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Not authenticated');

        $authClient->getSessionUser();
    }
}
