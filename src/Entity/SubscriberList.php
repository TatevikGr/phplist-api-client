<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use DateTimeImmutable;
use Exception;
use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for a subscriber list.
 */
class SubscriberList extends AbstractResponse
{
    /**
     * @var int The list ID
     */
    public int $id;

    /**
     * @var string The list name
     */
    public string $name;

    /**
     * @var DateTimeImmutable The creation date
     */
    public DateTimeImmutable $createdAt;

    /**
     * @var string|null The list description
     */
    public ?string $description;

    /**
     * @var int|null The list position
     */
    public ?int $listPosition;

    /**
     * @var string|null The subject prefix
     */
    public ?string $subjectPrefix;

    /**
     * @var bool Whether the list is public
     */
    public bool $public;

    /**
     * @var string|null The list category
     */
    public ?string $category;

    /**
     * @throws Exception
     */
    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->name = isset($data['name']) ? (string)$data['name'] : '';
        $createdAt = $data['created_at'] ?? '@0';
        $this->createdAt = new DateTimeImmutable($createdAt);
        $this->description = isset($data['description']) ? (string)$data['description'] : null;
        $this->listPosition = isset($data['list_position']) ? (int)$data['list_position'] : null;
        $this->subjectPrefix = isset($data['subject_prefix']) ? (string)$data['subject_prefix'] : null;
        $this->public = isset($data['public']) && (bool)$data['public'];
        $this->category = isset($data['category']) ? (string)$data['category'] : null;
    }
}
