<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Response;

use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Response\CursorPagination;

class CursorPaginationTest extends TestCase
{
    public function testFromArray(): void
    {
        $data = [
            'total' => 100,
            'limit' => 25,
            'has_more' => true,
            'next_cursor' => 129,
        ];

        $pagination = new CursorPagination($data);

        $this->assertSame(100, $pagination->total);
        $this->assertSame(25, $pagination->limit);
        $this->assertTrue($pagination->hasMore);
        $this->assertSame(129, $pagination->nextCursor);
    }

    public function testFromArrayWithDefaults(): void
    {
        $data = [
            'total' => 100,
        ];

        $pagination = new CursorPagination($data);

        $this->assertSame(100, $pagination->total);
        $this->assertSame(CursorPagination::DEFAULT_LIMIT, $pagination->limit);
        $this->assertFalse($pagination->hasMore);
        $this->assertNull($pagination->nextCursor);
    }

    public function testToArray(): void
    {
        $pagination = new CursorPagination([
            'total' => 100,
            'limit' => 25,
            'has_more' => true,
            'next_cursor' => 129,
        ]);

        $data = $pagination->toArray();

        $this->assertSame([
            'total' => 100,
            'limit' => 25,
            'has_more' => true,
            'next_cursor' => 129,
        ], $data);
    }
}
