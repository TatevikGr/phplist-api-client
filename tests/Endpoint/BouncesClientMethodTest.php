<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\BouncesClient;
use PhpList\RestApiClient\Response\Bounces\BounceCollection;
use PHPUnit\Framework\TestCase;

class BouncesClientMethodTest extends TestCase
{
    public function testListReturnsBounceCollection(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('bounces')
            ->willReturn([
                [
                    'id' => 10,
                    'status' => 'not processed',
                    'date' => '2023-01-01T12:00:00Z',
                    'message_id' => 123,
                    'message_subject' => 'Newsletter',
                    'subscriber_id' => 456,
                    'subscriber_email' => 'user@example.com',
                    'comment' => 'Soft bounce',
                ],
            ]);

        $bouncesClient = new BouncesClient($mockClient);
        $result = $bouncesClient->list();

        $this->assertInstanceOf(BounceCollection::class, $result);
        $this->assertCount(1, $result->items);
        $this->assertSame(10, $result->items[0]->id);
        $this->assertSame(123, $result->items[0]->messageId);
        $this->assertSame('user@example.com', $result->items[0]->subscriberEmail);
    }

    public function testListByCampaignReturnsRawArray(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('bounces/by/campaign')
            ->willReturn([
                [
                    'message_id' => 1,
                    'subject' => 'System',
                    'total_bounces' => 3,
                ],
            ]);

        $bouncesClient = new BouncesClient($mockClient);
        $result = $bouncesClient->listByCampaign();

        $this->assertIsArray($result);
        $this->assertSame(1, $result[0]['message_id']);
        $this->assertSame(3, $result[0]['total_bounces']);
    }

    public function testListBySubscriberReturnsRawArray(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('bounces/by/subscriber')
            ->willReturn([
                [
                    'subscriber_id' => 1,
                    'email' => 'example@email.com',
                    'confirmed' => true,
                    'blacklisted' => false,
                    'total_bounces' => 2,
                ],
            ]);

        $bouncesClient = new BouncesClient($mockClient);
        $result = $bouncesClient->listBySubscriber();

        $this->assertIsArray($result);
        $this->assertSame(1, $result[0]['subscriber_id']);
        $this->assertSame(2, $result[0]['total_bounces']);
    }
}
