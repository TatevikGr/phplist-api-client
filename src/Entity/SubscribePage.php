<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for a subscribe page.
 */
class SubscribePage extends AbstractResponse
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $title;

    /** @var bool */
    public bool $active;

    /** @var Administrator|null */
    public ?Administrator $owner = null;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->title = isset($data['title']) ? (string)$data['title'] : '';
        $this->active = isset($data['active']) && (bool)$data['active'];

        if (isset($data['owner']) && is_array($data['owner'])) {
            try {
                $this->owner = new Administrator($data['owner']);
            } catch (\Throwable) {
                $this->owner = null;
            }
        }
    }
}
