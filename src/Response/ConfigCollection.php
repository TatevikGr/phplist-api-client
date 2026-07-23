<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response;

use PhpList\RestApiClient\Entity\Config;

/**
 * Response class for a list of configs.
 */
class ConfigCollection extends AbstractCollectionResponse
{
    /**
     * @var Config[] The list of templates
     */
    public array $items = [];

    protected function processItems(array $items): void
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->items[] = new Config($item);
        }
    }
}
