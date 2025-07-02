<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Admin;

use PhpList\RestApiClient\Request\AbstractRequest;

/**
 * Request class for updating an administrator attribute definition.
 */
class UpdateAdminAttributeDefinitionRequest extends AbstractRequest
{
    /**
     * @var string|null The attribute name
     */
    public ?string $name = null;

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
    public ?string $default_value = null;

    /**
     * @var bool|null Whether the attribute is required
     */
    public ?bool $required = null;

    /**
     * @var string|null The table name
     */
    public ?string $table_name = null;

    /**
     * UpdateAdminAttributeDefinitionRequest constructor.
     *
     * @param string|null $name The attribute name
     * @param string|null $type The attribute type
     * @param int|null $order The attribute order
     * @param string|null $default_value The default value
     * @param bool|null $required Whether the attribute is required
     * @param string|null $table_name The table name
     */
    public function __construct(
        ?string $name = null,
        ?string $type = null,
        ?int $order = null,
        ?string $default_value = null,
        ?bool $required = null,
        ?string $table_name = null
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->order = $order;
        $this->default_value = $default_value;
        $this->required = $required;
        $this->table_name = $table_name;
    }
}
