<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request;

/**
 * Request class for creating a subscriber list.
 */
class CreateSubscriberListRequest extends AbstractRequest
{
    /** @var string The list name */
    public string $name;

    /** @var bool Whether the list is public */
    public bool $public = false;

    /** @var int|null The list position */
    public ?int $listPosition = null;

    /** @var string|null The list description */
    public ?string $description = null;

    /**
     * @SuppressWarnings("BooleanArgumentFlag")
     */
    public function __construct(
        string $name,
        bool $public = false,
        ?int $listPosition = null,
        ?string $description = null
    ) {
        $this->name = $name;
        $this->public = $public;
        $this->listPosition = $listPosition;
        $this->description = $description;
    }
}
