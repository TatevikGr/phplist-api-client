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
    public bool $has_more;

    /**
     * @var int|null The cursor for the next page of items
     */
    public ?int $next_cursor;

    /**
     * Create a pagination object from an array of data.
     *
     * @param array $data The pagination data as an array
     * @return static The pagination object
     */
    public static function fromArray(array $data): self
    {
        $instance = new static();
        $instance->total = $data['total'] ?? 0;
        $instance->limit = $data['limit'] ?? 0;
        $instance->has_more = $data['has_more'] ?? false;
        $instance->next_cursor = $data['next_cursor'] ?? null;
        
        return $instance;
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
            'has_more' => $this->has_more,
            'next_cursor' => $this->next_cursor,
        ];
    }
}
