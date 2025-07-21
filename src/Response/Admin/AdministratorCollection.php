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

    protected function processItems(array $items): void
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->items[] = new Administrator($item);
        }
    }
}
