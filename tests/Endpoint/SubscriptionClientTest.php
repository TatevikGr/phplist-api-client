<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\SubscriptionClient;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;

class SubscriptionClientTest extends TestCase
{
    private Client|MockObject $clientMock;
    private SubscriptionClient $subscriptionClient;

    protected function setUp(): void
    {
        $this->clientMock = $this->createMock(Client::class);
        $this->subscriptionClient = new SubscriptionClient($this->clientMock);
    }

    public function testGetSubscribers(): void
    {
        $expectedResponse = [
            'data' => [
                ['id' => 1, 'email' => 'test1@example.com'],
                ['id' => 2, 'email' => 'test2@example.com'],
            ],
            'meta' => ['total' => 2]
        ];

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('subscribers', ['limit' => 25])
            ->willReturn($expectedResponse);

        $result = $this->subscriptionClient->getSubscribers();
        $this->assertSame($expectedResponse, $result);
    }

    public function testGetSubscribersWithPagination(): void
    {
        $expectedResponse = [
            'data' => [
                ['id' => 3, 'email' => 'test3@example.com'],
                ['id' => 4, 'email' => 'test4@example.com'],
            ],
            'meta' => ['total' => 2]
        ];

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('subscribers', ['limit' => 10, 'after_id' => 2])
            ->willReturn($expectedResponse);

        $result = $this->subscriptionClient->getSubscribers(2, 10);
        $this->assertSame($expectedResponse, $result);
    }

    public function testGetSubscriber(): void
    {
        $subscriberId = 1;
        $expectedResponse = [
            'id' => $subscriberId,
            'email' => 'test@example.com',
            'confirmed' => true,
            'blacklisted' => false,
        ];

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with("subscribers/{$subscriberId}")
            ->willReturn($expectedResponse);

        $result = $this->subscriptionClient->getSubscriber($subscriberId);
        $this->assertSame($expectedResponse, $result);
    }

    public function testGetSubscriberNotFound(): void
    {
        $subscriberId = 999;

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with("subscribers/{$subscriberId}")
            ->willThrowException(new NotFoundException('Subscriber not found'));

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Subscriber not found');

        $this->subscriptionClient->getSubscriber($subscriberId);
    }

    public function testCreateSubscriber(): void
    {
        $subscriberData = [
            'email' => 'new@example.com',
            'confirmed' => true,
        ];

        $expectedResponse = [
            'id' => 5,
            'email' => 'new@example.com',
            'confirmed' => true,
            'blacklisted' => false,
        ];

        $this->clientMock->expects($this->once())
            ->method('post')
            ->with('subscribers', $subscriberData)
            ->willReturn($expectedResponse);

        $result = $this->subscriptionClient->createSubscriber($subscriberData);
        $this->assertSame($expectedResponse, $result);
    }

    public function testCreateSubscriberValidationError(): void
    {
        $subscriberData = [
            'email' => 'invalid-email',
        ];

        $this->clientMock->expects($this->once())
            ->method('post')
            ->with('subscribers', $subscriberData)
            ->willThrowException(new ValidationException('Validation failed', 422, ['email' => ['Invalid email format']]));

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Validation failed');

        $this->subscriptionClient->createSubscriber($subscriberData);
    }

    public function testUpdateSubscriber(): void
    {
        $subscriberId = 1;
        $subscriberData = [
            'confirmed' => false,
        ];

        $expectedResponse = [
            'id' => $subscriberId,
            'email' => 'test@example.com',
            'confirmed' => false,
            'blacklisted' => false,
        ];

        $this->clientMock->expects($this->once())
            ->method('put')
            ->with("subscribers/{$subscriberId}", $subscriberData)
            ->willReturn($expectedResponse);

        $result = $this->subscriptionClient->updateSubscriber($subscriberId, $subscriberData);
        $this->assertSame($expectedResponse, $result);
    }

    public function testDeleteSubscriber(): void
    {
        $subscriberId = 1;
        $expectedResponse = ['success' => true];

        $this->clientMock->expects($this->once())
            ->method('delete')
            ->with("subscribers/{$subscriberId}")
            ->willReturn($expectedResponse);

        $result = $this->subscriptionClient->deleteSubscriber($subscriberId);
        $this->assertSame($expectedResponse, $result);
    }

    public function testAddSubscriberToList(): void
    {
        $subscriberId = 1;
        $listId = 2;
        $expectedResponse = ['success' => true];

        $this->clientMock->expects($this->once())
            ->method('post')
            ->with("subscribers/{$subscriberId}/lists/{$listId}")
            ->willReturn($expectedResponse);

        $result = $this->subscriptionClient->addSubscriberToList($subscriberId, $listId);
        $this->assertSame($expectedResponse, $result);
    }

    public function testRemoveSubscriberFromList(): void
    {
        $subscriberId = 1;
        $listId = 2;
        $expectedResponse = ['success' => true];

        $this->clientMock->expects($this->once())
            ->method('delete')
            ->with("subscribers/{$subscriberId}/lists/{$listId}")
            ->willReturn($expectedResponse);

        $result = $this->subscriptionClient->removeSubscriberFromList($subscriberId, $listId);
        $this->assertSame($expectedResponse, $result);
    }
}
