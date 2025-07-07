<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Response;

use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;
use PhpList\RestApiClient\Response\CursorPagination;

class TestCollectionResponse extends AbstractCollectionResponse
{
    /**
     * @var array The list of items in the collection
     */
    public array $items = [];

    /**
     * Process the items in the collection.
     *
     * @param array $data The response data as an array
     */
    protected function processItems(array $data): void
    {
        $this->items = $data['items'] ?? $data;
    }
}

class AbstractCollectionResponseTest extends TestCase
{
    public function testFromArray(): void
    {
        $data = [
            'total' => 100,
            'limit' => 25,
            'has_more' => true,
            'next_cursor' => 129,
            'items' => [
                ['id' => 1, 'name' => 'Item 1'],
                ['id' => 2, 'name' => 'Item 2'],
            ],
        ];

        $response = TestCollectionResponse::fromArray($data);

        $this->assertInstanceOf(CursorPagination::class, $response->pagination);
        $this->assertSame(100, $response->pagination->total);
        $this->assertSame(25, $response->pagination->limit);
        $this->assertTrue($response->pagination->has_more);
        $this->assertSame(129, $response->pagination->next_cursor);
        $this->assertCount(2, $response->items);
        $this->assertSame(['id' => 1, 'name' => 'Item 1'], $response->items[0]);
        $this->assertSame(['id' => 2, 'name' => 'Item 2'], $response->items[1]);
    }

    public function testFromArrayWithDefaults(): void
    {
        $data = [
            'items' => [
                ['id' => 1, 'name' => 'Item 1'],
                ['id' => 2, 'name' => 'Item 2'],
            ],
        ];

        $response = TestCollectionResponse::fromArray($data);

        $this->assertInstanceOf(CursorPagination::class, $response->pagination);
        $this->assertSame(2, $response->pagination->total);
        $this->assertSame(0, $response->pagination->limit);
        $this->assertFalse($response->pagination->has_more);
        $this->assertNull($response->pagination->next_cursor);
        $this->assertCount(2, $response->items);
    }

    public function testToArray(): void
    {
        $response = new TestCollectionResponse();
        $response->pagination = new CursorPagination([
            'total' => 100,
            'limit' => 25,
            'has_more' => true,
            'next_cursor' => 129,
        ]);
        $response->items = [
            ['id' => 1, 'name' => 'Item 1'],
            ['id' => 2, 'name' => 'Item 2'],
        ];

        $data = $response->toArray();

        $this->assertSame([
            'total' => 100,
            'limit' => 25,
            'has_more' => true,
            'next_cursor' => 129,
            'items' => [
                ['id' => 1, 'name' => 'Item 1'],
                ['id' => 2, 'name' => 'Item 2'],
            ],
        ], $data);
    }
}
