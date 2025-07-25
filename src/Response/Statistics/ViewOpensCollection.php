<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Statistics;

use PhpList\RestApiClient\Entity\Statistics\ViewOpen;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a collection of view/open statistics.
 */
class ViewOpensCollection extends AbstractCollectionResponse
{
    /**
     * @var ViewOpen[] The list of view/open statistics
     */
    public array $items = [];

    protected function processItems(array $items): void
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->items[] = new ViewOpen($item);
        }
    }
}
