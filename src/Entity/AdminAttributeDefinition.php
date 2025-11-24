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
    public ?string $defaultValue = null;

    /**
     * @var string|null The attribute description
     */
    public ?string $description = null;

    public ?int $listOrder = null;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->name = isset($data['name']) ? (string)$data['name'] : '';
        $this->type = isset($data['type']) ? (string)$data['type'] : '';
        $this->required = isset($data['required']) && (bool)$data['required'];

        $this->defaultValue = isset($data['default_value']) ? (string)$data['default_value'] : null;
        $this->description = isset($data['description']) ? (string)$data['description'] : null;
        $this->listOrder = isset($data['list_order']) ? (int)$data['list_order'] : null;
    }
}
