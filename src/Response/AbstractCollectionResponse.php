<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response;

/**
 * Abstract base class for all API collection response classes.
 */
abstract class AbstractCollectionResponse extends AbstractResponse
{
    /**
     * @var array The list of items in the collection
     */
    public array $items = [];

    /**
     * @var CursorPagination The pagination information
     */
    public CursorPagination $pagination;

    /**
     * Create a response object from an array of data returned by the API.
     *
     * @param array $data The response data as an array
     * @return void The response object
     */

    public function __construct(array $data)
    {
        $paginationData = $data['pagination'] ?? [];
        $pagination = [
            'total' => $paginationData['total'] ?? count($data['items'] ?? $data),
            'limit' => (int)($paginationData['limit'] ?? null),
            'has_more' => $paginationData['has_more'] ?? false,
            'next_cursor' => $paginationData['next_cursor'] ?? null,
        ];

        $this->pagination = new CursorPagination($pagination);
        $this->processItems($data['items'] ?? []);
    }

    /**
     * Process the items in the collection.
     * This method should be implemented by child classes.
     *
     * @param array $items The response data as an array
     */
    abstract protected function processItems(array $items): void;

    /**
     * Convert the response to an array.
     *
     * @return array The response data as an array
     */
    public function toArray(): array
    {
        $data = $this->pagination->toArray();
        $data['items'] = $this->getItemsAsArray();

        return $data;
    }

    /**
     * Get the items as an array.
     * This method should be implemented by child classes if they need custom conversion logic.
     *
     * @return array The items as an array
     */
    protected function getItemsAsArray(): array
    {
        $items = [];
        foreach ($this->items as $item) {
            if (is_object($item) && method_exists($item, 'toArray')) {
                $items[] = $item->toArray();
            } else {
                $items[] = $item;
            }
        }

        return $items;
    }
}
