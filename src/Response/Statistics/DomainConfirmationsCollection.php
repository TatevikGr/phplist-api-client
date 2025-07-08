<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Statistics;

use PhpList\RestApiClient\Entity\Statistics\DomainConfirmation;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a collection of domain confirmation statistics.
 */
class DomainConfirmationsCollection extends AbstractCollectionResponse
{
    /**
     * @var DomainConfirmation[] The list of domain confirmation statistics
     */
    public array $items = [];

    protected function processItems(array $data): void
    {
        $this->items = [];
        foreach ($data['items'] ?? $data as $item) {
            $this->items[] = new DomainConfirmation($item);
        }
    }
}
