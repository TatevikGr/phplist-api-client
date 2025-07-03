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

        $pagination = CursorPagination::fromArray($data);

        $this->assertSame(100, $pagination->total);
        $this->assertSame(25, $pagination->limit);
        $this->assertTrue($pagination->has_more);
        $this->assertSame(129, $pagination->next_cursor);
    }

    public function testFromArrayWithDefaults(): void
    {
        $data = [
            'total' => 100,
        ];

        $pagination = CursorPagination::fromArray($data);

        $this->assertSame(100, $pagination->total);
        $this->assertSame(0, $pagination->limit);
        $this->assertFalse($pagination->has_more);
        $this->assertNull($pagination->next_cursor);
    }

    public function testToArray(): void
    {
        $pagination = new CursorPagination();
        $pagination->total = 100;
        $pagination->limit = 25;
        $pagination->has_more = true;
        $pagination->next_cursor = 129;

        $data = $pagination->toArray();

        $this->assertSame([
            'total' => 100,
            'limit' => 25,
            'has_more' => true,
            'next_cursor' => 129,
        ], $data);
    }
}
