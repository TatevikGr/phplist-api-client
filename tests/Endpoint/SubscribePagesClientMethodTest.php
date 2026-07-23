<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\SubscribePagesClient;
use PhpList\RestApiClient\Entity\Subscription;
use PhpList\RestApiClient\Request\SubscribePage\PublicSubscriptionRequest;
use PHPUnit\Framework\TestCase;

class SubscribePagesClientMethodTest extends TestCase
{
    public function testCreatePublicSubscription(): void
    {
        $pageId = 12;
        $request = new PublicSubscriptionRequest(
            'lia@example.com',
            1,
            'lia@example.com',
            ['firstname' => 'Lia', 'country' => 'Armenia']
        );

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('post')
            ->with(
                'public/subscribe-pages/' . $pageId,
                [
                    'email' => 'lia@example.com',
                    'confirm_email' => 'lia@example.com',
                    'list_id' => 1,
                    'attributes' => ['firstname' => 'Lia', 'country' => 'Armenia'],
                ]
            )
            ->willReturn([
                [
                    'subscriber' => [
                        'id' => 100,
                        'email' => 'lia@example.com',
                    ],
                    'subscriber_list' => [
                        'id' => 1,
                        'name' => 'Newsletter',
                        'created_at' => '2026-06-03T10:00:00+00:00',
                    ],
                    'subscription_date' => '2026-06-03T10:30:00+00:00',
                ],
            ]);

        $subscribePagesClient = new SubscribePagesClient($mockClient);
        $subscriptions = $subscribePagesClient->createPublicSubscription($pageId, $request);

        $this->assertCount(1, $subscriptions);
        $this->assertInstanceOf(Subscription::class, $subscriptions[0]);
        $this->assertSame('lia@example.com', $subscriptions[0]->subscriber->email);
        $this->assertSame(1, $subscriptions[0]->subscriberList->id);
    }
}
