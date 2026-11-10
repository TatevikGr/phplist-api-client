<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response;

use PhpList\RestApiClient\Entity\AdminNotification;

/**
 * Response class for a list of admin notifications.
 */
class AdminNotificationCollection extends AbstractCollectionResponse
{
    /**
     * @var AdminNotification[] The list of notifications
     */
    public array $items = [];

    protected function processItems(array $items): void
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->items[] = new AdminNotification($item);
        }
    }
}
