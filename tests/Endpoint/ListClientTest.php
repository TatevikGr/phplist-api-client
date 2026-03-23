<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\ListClient;
use PhpList\RestApiClient\Entity\SubscriberList;
use PhpList\RestApiClient\Request\CreateSubscriberListRequest;
use PhpList\RestApiClient\Response\Subscribers\SubscriberListCollection;
use PHPUnit\Framework\TestCase;

class ListClientTest extends TestCase
{
    public function testGetListsSendsPaginationParameters(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('/lists', ['limit' => 50, 'after_id' => 10])
            ->willReturn(['items' => [], 'pagination' => []]);

        $listClient = new ListClient($mockClient);
        $result = $listClient->getLists(10, 50);

        $this->assertInstanceOf(SubscriberListCollection::class, $result);
    }

    public function testCreateListCallsApiAndReturnsEntity(): void
    {
        $mockClient = $this->createMock(Client::class);
        $request = new CreateSubscriberListRequest('News', true, 1, 'Newsletter list');
        $expectedPayload = [
            'name' => 'News',
            'public' => true,
            'list_position' => 1,
            'description' => 'Newsletter list',
        ];

        $mockClient->expects($this->once())
            ->method('post')
            ->with('/lists', $expectedPayload)
            ->willReturn([
                'id' => 3,
                'name' => 'News',
                'created_at' => '2026-01-01T10:00:00Z',
                'description' => 'Newsletter list',
                'list_position' => 1,
                'public' => true,
            ]);

        $listClient = new ListClient($mockClient);
        $result = $listClient->createList($request);

        $this->assertInstanceOf(SubscriberList::class, $result);
        $this->assertSame(3, $result->id);
        $this->assertSame('News', $result->name);
    }

    public function testGetListCallsApiAndReturnsEntity(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('/lists/7')
            ->willReturn([
                'id' => 7,
                'name' => 'Customers',
                'created_at' => '2026-01-01T10:00:00Z',
                'public' => false,
            ]);

        $listClient = new ListClient($mockClient);
        $result = $listClient->getList(7);

        $this->assertInstanceOf(SubscriberList::class, $result);
        $this->assertSame(7, $result->id);
        $this->assertSame('Customers', $result->name);
    }

    public function testDeleteListCallsApi(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('delete')
            ->with('/lists/7');

        $listClient = new ListClient($mockClient);
        $listClient->deleteList(7);

        $this->assertTrue(true);
    }
}
