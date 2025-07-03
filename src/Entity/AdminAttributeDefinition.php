<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Response class for administrator attribute definition.
 */
class AdminAttributeDefinition extends AbstractResponse
{
    /**
     * @var int The attribute definition ID
     */
    public int $id;

    /**
     * @var string The attribute name
     */
    public string $name;

    /**
     * @var string The attribute type
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
     * @var array|null The attribute options (for select type)
     */
    public ?array $options = null;

    /**
     * @var string|null The attribute description
     */
    public ?string $description = null;

    public ?int $list_order = null;
    public ?string $table_name = null;
}
