<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Response;

use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Response\CursorPagination;

class AbstractCollectionResponseTest extends TestCase
{
    public function testFromArray(): void
    {
        $data = [
            'pagination' => [
                'total' => 100,
                'limit' => 25,
                'has_more' => true,
                'next_cursor' => 129,
            ],
            'items' => [
                ['id' => 1, 'name' => 'Item 1'],
                ['id' => 2, 'name' => 'Item 2'],
            ],
        ];

        $response = new TestCollectionResponse($data);

        $this->assertInstanceOf(CursorPagination::class, $response->pagination);
        $this->assertSame(100, $response->pagination->total);
        $this->assertSame(25, $response->pagination->limit);
        $this->assertTrue($response->pagination->hasMore);
        $this->assertSame(129, $response->pagination->nextCursor);
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

        $response = new TestCollectionResponse($data);

        $this->assertInstanceOf(CursorPagination::class, $response->pagination);
        $this->assertSame(2, $response->pagination->total);
        $this->assertSame(0, $response->pagination->limit);
        $this->assertFalse($response->pagination->hasMore);
        $this->assertNull($response->pagination->nextCursor);
        $this->assertCount(2, $response->items);
    }

    public function testToArray(): void
    {
        $response = new TestCollectionResponse([
            'items' => [
                ['id' => 1, 'name' => 'Item 1'],
                ['id' => 2, 'name' => 'Item 2'],
            ],
            'pagination' => [
                'total' => 100,
                'limit' => 25,
                'has_more' => true,
                'next_cursor' => 129,
            ]
        ]);
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
