<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Admin;

use PhpList\RestApiClient\Entity\Administrator;
use PhpList\RestApiClient\Response\AbstractCollectionResponse;

/**
 * Response class for a list of administrators.
 */
class AdministratorCollection extends AbstractCollectionResponse
{
    /**
     * @var Administrator[] The list of administrators
     */
    public array $items = [];

    /**
     * Process the items in the collection.
     *
     * @param array $data The response data as an array
     */
    protected function processItems(array $data): void
    {
        $this->items = [];
        foreach ($data['items'] ?? $data as $item) {
            $this->items[] = Administrator::fromArray($item);
        }
    }
}
