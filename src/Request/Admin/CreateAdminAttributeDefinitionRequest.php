<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Admin;

use PhpList\RestApiClient\Request\AbstractRequest;

/**
 * Request class for creating an administrator attribute definition.
 */
class CreateAdminAttributeDefinitionRequest extends AbstractRequest
{
    /**
     * @var string The attribute name
     */
    public string $name;

    /**
     * @var string|null The attribute type
     */
    public ?string $type = null;

    /**
     * @var int|null The attribute order
     */
    public ?int $order = null;

    /**
     * @var string|null The default value
     */
    public ?string $defaultValue = null;

    /**
     * @var bool|null Whether the attribute is required
     */
    public ?bool $required = null;

    /**
     * @var string|null The table name
     */
    public ?string $tableName = null;

    /**
     * CreateAdminAttributeDefinitionRequest constructor.
     *
     * @param string $name The attribute name
     * @param string|null $type The attribute type
     * @param int|null $order The attribute order
     * @param string|null $defaultValue The default value
     * @param bool|null $required Whether the attribute is required
     * @param string|null $tableName The table name
     */
    public function __construct(
        string $name,
        ?string $type = null,
        ?int $order = null,
        ?string $defaultValue = null,
        ?bool $required = null,
        ?string $tableName = null
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->order = $order;
        $this->defaultValue = $defaultValue;
        $this->required = $required;
        $this->tableName = $tableName;
    }
}
