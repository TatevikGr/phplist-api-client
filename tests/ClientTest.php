<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\AuthenticationException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;
use Psr\Log\LoggerInterface;
use ReflectionClass;

class ClientTest extends TestCase
{
    private GuzzleClient|MockObject $guzzleClientMock;
    private Client $client;

    protected function setUp(): void
    {
        $this->guzzleClientMock = $this->createMock(GuzzleClient::class);
        $loggerMock = $this->createMock(LoggerInterface::class);

        $clientReflection = new ReflectionClass(Client::class);
        $this->client = $clientReflection->newInstanceWithoutConstructor();

        $httpClientProperty = $clientReflection->getProperty('httpClient');
        $httpClientProperty->setValue($this->client, $this->guzzleClientMock);

        $loggerProperty = $clientReflection->getProperty('logger');
        $loggerProperty->setValue($this->client, $loggerMock);

        $baseUrlProperty = $clientReflection->getProperty('baseUrl');
        $baseUrlProperty->setValue($this->client, 'https://api.example.com');
    }

    public function testLogin(): void
    {
        $username = 'testuser';
        $password = 'testpass';
        $sessionId = 'test-session-id';

        $response = new Response(200, [], json_encode([
            'key' => $sessionId,
            'expires' => '2023-12-31T23:59:59Z',
        ]));

        $this->guzzleClientMock->expects($this->once())
            ->method('post')
            ->with('sessions', [
                'json' => [
                    'login_name' => $username,
                    'password' => $password,
                ],
            ])
            ->willReturn($response);

        $result = $this->client->login($username, $password);

        $this->assertArrayHasKey('key', $result);
        $this->assertEquals($sessionId, $result['key']);
        $this->assertEquals($sessionId, $this->client->getSessionId());
    }

    public function testLoginFailure(): void
    {
        $username = 'testuser';
        $password = 'wrongpass';

        $response = new Response(401, [], json_encode([
            'message' => 'Invalid credentials',
        ]));

        $this->guzzleClientMock->expects($this->once())
            ->method('post')
            ->willReturn($response);

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $this->client->login($username, $password);
    }

    public function testGet(): void
    {
        $endpoint = 'test-endpoint';
        $queryParams = ['param1' => 'value1', 'param2' => 'value2'];
        $expectedData = ['key' => 'value'];

        $response = new Response(200, [], json_encode($expectedData));

        $this->guzzleClientMock->expects($this->once())
            ->method('request')
            ->with('GET', '/api/v2/test-endpoint', ['query' => $queryParams])
            ->willReturn($response);

        $result = $this->client->get($endpoint, $queryParams);

        $this->assertEquals($expectedData, $result);
    }

    public function testPost(): void
    {
        $endpoint = 'test-endpoint';
        $data = ['field1' => 'value1', 'field2' => 'value2'];
        $expectedData = ['id' => 123, 'field1' => 'value1', 'field2' => 'value2'];

        $response = new Response(201, [], json_encode($expectedData));

        $this->guzzleClientMock->expects($this->once())
            ->method('request')
            ->with('POST', '/api/v2/test-endpoint', ['json' => $data])
            ->willReturn($response);

        $result = $this->client->post($endpoint, $data);

        $this->assertEquals($expectedData, $result);
    }

    public function testPut(): void
    {
        $endpoint = 'test-endpoint/123';
        $data = ['field1' => 'updated'];
        $expectedData = ['id' => 123, 'field1' => 'updated', 'field2' => 'value2'];

        $response = new Response(200, [], json_encode($expectedData));

        $this->guzzleClientMock->expects($this->once())
            ->method('request')
            ->with('PUT', '/api/v2/test-endpoint/123', ['json' => $data])
            ->willReturn($response);

        $result = $this->client->put($endpoint, $data);

        $this->assertEquals($expectedData, $result);
    }

    public function testDelete(): void
    {
        $endpoint = 'test-endpoint/123';
        $expectedData = ['success' => true];

        $response = new Response(200, [], json_encode($expectedData));

        $this->guzzleClientMock->expects($this->once())
            ->method('request')
            ->with('DELETE', '/api/v2/test-endpoint/123')
            ->willReturn($response);

        $result = $this->client->delete($endpoint);

        $this->assertEquals($expectedData, $result);
    }

    public function testNotFound(): void
    {
        $endpoint = 'test-endpoint/999';

        $response = new Response(404, [], json_encode([
            'message' => 'Resource not found',
        ]));

        $this->guzzleClientMock->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Resource not found');

        $this->client->get($endpoint);
    }

    public function testValidationError(): void
    {
        $endpoint = 'test-endpoint';
        $data = ['field1' => 'invalid'];

        $response = new Response(422, [], json_encode([
            'message' => 'Validation failed',
            'errors' => [
                'field1' => ['The field1 value is invalid'],
            ],
        ]));

        $this->guzzleClientMock->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Validation failed');

        $this->client->post($endpoint, $data);
    }

    public function testApiError(): void
    {
        $endpoint = 'test-endpoint';

        $response = new Response(500, [], json_encode([
            'message' => 'Internal server error',
        ]));

        $this->guzzleClientMock->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Internal server error');

        $this->client->get($endpoint);
    }

    public function testSetSessionId(): void
    {
        $sessionId = 'test-session-id';
        $endpoint = 'test-endpoint';
        $expectedData = ['key' => 'value'];

        $response = new Response(200, [], json_encode($expectedData));

        $this->guzzleClientMock->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                '/api/v2/test-endpoint',
                $this->callback(function ($options) use ($sessionId) {
                    return isset($options['headers']['session']) && $options['headers']['session'] === $sessionId;
                })
            )
            ->willReturn($response);

        $this->client->setSessionId($sessionId);
        $result = $this->client->get($endpoint);

        $this->assertEquals($expectedData, $result);
        $this->assertEquals($sessionId, $this->client->getSessionId());
    }
}
