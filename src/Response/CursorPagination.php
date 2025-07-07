<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response;

/**
 * Class representing cursor-based pagination information.
 */
class CursorPagination
{
    /**
     * @var int The total number of items
     */
    public int $total;

    /**
     * @var int The limit of items per page
     */
    public int $limit;

    /**
     * @var bool Whether there are more items available
     */
    public bool $hasMore;

    /**
     * @var int|null The cursor for the next page of items
     */
    public ?int $nextCursor;

    /**
     * Create a pagination object from an array of data.
     *
     * @param array $data The pagination data as an array
     */
    public function __construct(array $data)
    {
        $this->total = $data['total'] ?? 0;
        $this->limit = $data['limit'] ?? 0;
        $this->hasMore = $data['has_more'] ?? false;
        $this->nextCursor = $data['next_cursor'] ?? null;
    }

    /**
     * Convert the pagination to an array.
     *
     * @return array The pagination data as an array
     */
    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'limit' => $this->limit,
            'has_more' => $this->hasMore,
            'next_cursor' => $this->nextCursor,
        ];
    }
}
