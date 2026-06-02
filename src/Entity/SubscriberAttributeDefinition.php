<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;
use PhpList\RestApiClient\Response\AttributeOption;

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
    public ?string $defaultValue = null;

    /**
     * @var string|null The attribute description
     */
    public ?string $description = null;

    public ?int $listOrder = null;

    public array $options = [];

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->name = isset($data['name']) ? (string)$data['name'] : '';
        $this->type = isset($data['type']) ? (string)$data['type'] : '';
        $this->required = isset($data['required']) && (bool)$data['required'];

        $this->defaultValue = isset($data['default_value']) ? (string)$data['default_value'] : null;
        $this->description = isset($data['description']) ? (string)$data['description'] : null;
        $this->listOrder = isset($data['list_order']) ? (int)$data['list_order'] : null;
        $this->options = array_map(fn($opt) => new AttributeOption((array)$opt), $data['options'] ?? []);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'required' => $this->required,
            'default_value' => $this->defaultValue,
            'description' => $this->description,
            'list_order' => $this->listOrder,
            'options' => array_map(fn($opt) => $opt->toArray(), $this->options ?? []),
        ];
    }
}
