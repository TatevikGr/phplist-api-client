<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\SubscriptionClient;
use PhpList\RestApiClient\Entity\SubscriberList;
use PhpList\RestApiClient\Entity\Subscription;
use PhpList\RestApiClient\Request\CreateSubscriberListRequest;
use PhpList\RestApiClient\Response\Subscribers\SubscriberListCollection;
use PhpList\RestApiClient\Response\Subscribers\SubscriberCollection;
use PHPUnit\Framework\TestCase;

class SubscriptionClientTest extends TestCase
{
    private SubscriptionClient $subscriptionClient;

    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $client = new Client($baseUrl);
        $client->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->subscriptionClient = new SubscriptionClient($client);
    }

    public function testCanCreateGetAndDeleteSubscriberList(): void
    {
        $createRequest = new CreateSubscriberListRequest(
            'Newsletter',
            true
        );
        $list = $this->subscriptionClient->createSubscriberList($createRequest);
        $this->assertInstanceOf(SubscriberList::class, $list);
        $this->assertEquals($createRequest->name, $list->name);

        $fetchedList = $this->subscriptionClient->getSubscriberList($list->id);
        $this->assertInstanceOf(SubscriberList::class, $fetchedList);
        $this->assertEquals($list->id, $fetchedList->id);

        $this->subscriptionClient->deleteSubscriberList($list->id);
        $this->assertTrue(true);
    }

    public function testCanGetSubscriberLists(): void
    {
        $lists = $this->subscriptionClient->getSubscriberLists();
        $this->assertInstanceOf(SubscriberListCollection::class, $lists);
    }

    public function testCanGetSubscribersCountForList(): void
    {
        $count = $this->subscriptionClient->getSubscribersCountForList(1);
        $this->assertIsArray($count);
        $this->assertArrayHasKey('subscribers_count', $count);
    }

    public function testCanAddAndRemoveSubscribersFromList(): void
    {
        $createRequest = new CreateSubscriberListRequest(
            'Test List Sub ' . uniqid(),
            false
        );
        $list = $this->subscriptionClient->createSubscriberList($createRequest);

        $testEmail = 'test_' . uniqid() . '@example.com';

        $subscriptions = $this->subscriptionClient->createSubscriptions([$testEmail], $list->id);
        $this->assertInstanceOf(Subscription::class, $subscriptions[0]);

        $subs = $this->subscriptionClient->getSubscribersOfList($list->id);
        $this->assertInstanceOf(SubscriberCollection::class, $subs);

        $this->subscriptionClient->deleteSubscription([$testEmail], $list->id);

        $this->subscriptionClient->deleteSubscriberList($list->id);

        $this->assertTrue(true);
    }

    public function testCanGetSubscribersOfList(): void
    {
        $lists = $this->subscriptionClient->getSubscriberLists();
        $firstList = $lists->items[0] ?? null;
        if ($firstList) {
            $subs = $this->subscriptionClient->getSubscribersOfList($firstList->id);
            $this->assertInstanceOf(SubscriberCollection::class, $subs);
        } else {
            $this->markTestSkipped('No lists found to get subscribers.');
        }
    }
}
