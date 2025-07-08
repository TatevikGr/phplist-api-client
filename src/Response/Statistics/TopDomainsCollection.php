<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Statistics;

use PhpList\RestApiClient\Entity\Statistics\TopDomain;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a collection of top domain statistics.
 */
class TopDomainsCollection extends AbstractCollectionResponse
{
    /**
     * @var TopDomain[] The list of top domain statistics
     */
    public array $items = [];

    protected function processItems(array $data): void
    {
        $this->items = [];
        foreach ($data['items'] ?? $data as $item) {
            $this->items[] = new TopDomain($item);
        }
    }
}
