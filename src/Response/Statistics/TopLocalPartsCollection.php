<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Statistics;

use PhpList\RestApiClient\Entity\Statistics\TopLocalPart;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a collection of top local part statistics.
 */
class TopLocalPartsCollection extends AbstractCollectionResponse
{
    /**
     * @var TopLocalPart[] The list of top local part statistics
     */
    public array $items = [];

    protected function processItems(array $data): void
    {
        $this->items = [];
        foreach ($data['items'] ?? $data as $item) {
            $this->items[] = new TopLocalPart($item);
        }
    }
}
