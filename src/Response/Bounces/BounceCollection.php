<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Bounces;

use PhpList\RestApiClient\Entity\Bounce;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a list of bounces.
 */
class BounceCollection extends AbstractCollectionResponse
{
    /**
     * @var Bounce[] The list of bounces
     */
    public array $items = [];

    public function __construct(array $data)
    {
        if (!isset($data['items']) || !is_array($data['items'])) {
            $data = [
                'items' => $data,
                'pagination' => [
                    'total' => count($data),
                    'limit' => count($data),
                    'has_more' => false,
                    'next_cursor' => null,
                ],
            ];
        }

        parent::__construct($data);
    }

    protected function processItems(array $items): void
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->items[] = new Bounce($item);
        }
    }
}
