<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for public subscriber list details.
 */
class PublicSubscriberList extends AbstractResponse
{
    /**
     * @var int The list ID
     */
    public int $id;

    /**
     * @var string The list name
     */
    public string $name;

    public ?int $listPosition;

    /**
     * @var string|null The list description
     */
    public ?string $description;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->name = isset($data['name']) ? (string)$data['name'] : '';
        $this->listPosition = isset($data['list_position']) ? (int)$data['list_position'] : null;
        $this->description = isset($data['description']) ? (string)$data['description'] : null;
    }
}
