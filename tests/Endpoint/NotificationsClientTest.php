<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\NotificationsClient;
use PhpList\RestApiClient\Response\AdminNotificationCollection;
use PHPUnit\Framework\TestCase;

class NotificationsClientTest extends TestCase
{
    public function testGetNotifications(): void
    {
        $client = $this->createMock(Client::class);
        $client->expects($this->once())
            ->method('get')
            ->with('notifications')
            ->willReturn(['items' => [[
                'code' => 'campaigns_in_queue',
                'level' => 'info',
                'message' => 'Campaigns are queued',
                'context' => ['count' => 2],
            ]]]);

        $result = (new NotificationsClient($client))->getNotifications();

        $this->assertInstanceOf(AdminNotificationCollection::class, $result);
        $this->assertCount(1, $result->items);
        $this->assertSame('campaigns_in_queue', $result->items[0]->code);
        $this->assertSame(['count' => 2], $result->items[0]->context);
    }
}
