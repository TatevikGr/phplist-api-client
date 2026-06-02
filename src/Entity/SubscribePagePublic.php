<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for public subscribe page.
 */
class SubscribePagePublic extends AbstractResponse
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $title;

    /** @var array */
    public array $data = [];

    public function __construct(array $data)
    {
        $this->id = (int)$data['id'];
        $this->title = (string)$data['title'];

        $this->data = $data['data'] ?? [];
    }
}
