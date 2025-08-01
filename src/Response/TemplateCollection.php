<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response;

use PhpList\RestApiClient\Entity\Template;

/**
 * Response class for a list of templates.
 */
class TemplateCollection extends AbstractCollectionResponse
{
    /**
     * @var Template[] The list of templates
     */
    public array $items = [];

    protected function processItems(array $items): void
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->items[] = new Template($item);
        }
    }
}
