<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Subscriber;

use PhpList\RestApiClient\Request\AbstractRequest;

class UpdateSubscriberAttributeDefinitionRequest extends AbstractRequest
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
    public ?string $defaultValue = null;

    /**
     * @var bool|null Whether the attribute is required
     */
    public ?bool $required = null;

    /**
     * @var array<int, array{id?: int|null, name: string, list_order?: int|null}>|null
     * Options for dynamic list attributes
     */
    public ?array $options = null;

    /**
     * @param string|null $name The attribute name
     * @param string|null $type The attribute type
     * @param int|null $order The attribute order
     * @param string|null $defaultValue The default value
     * @param bool|null $required Whether the attribute is required
     */
    public function __construct(
        ?string $name = null,
        ?string $type = null,
        ?int $order = null,
        ?string $defaultValue = null,
        ?bool $required = null,
        ?array $options = null,
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->order = $order;
        $this->defaultValue = $defaultValue;
        $this->required = $required;
        $this->options = $options;
    }
}
