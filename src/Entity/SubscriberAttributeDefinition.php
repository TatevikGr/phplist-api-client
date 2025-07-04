<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for a subscriber attribute definition.
 */
class SubscriberAttributeDefinition extends AbstractResponse
{
    /**
     * @var int The attribute definition ID
     */
    public int $id;

    /**
     * @var string The name of the attribute
     */
    public string $name;

    /**
     * @var string The type of the attribute
     */
    public string $type;

    /**
     * @var bool Whether the attribute is required
     */
    public bool $required;

    /**
     * @var string|null The attribute default value
     */
    public ?string $default_value = null;

    /**
     * @var string|null The attribute description
     */
    public ?string $description = null;

    public ?int $list_order = null;

    public ?string $table_name = null;
}
