<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use InvalidArgumentException;
use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Response class for administrator attribute value.
 */
class AdminAttributeValue extends AbstractResponse
{
    /**
     * @var Administrator The administrator
     */
    public Administrator $administrator;

    /**
     * @var AdminAttributeDefinition The attribute definition
     */
    public AdminAttributeDefinition $definition;

    /**
     * @var string|null The attribute value
     */
    public ?string $value = null;

    public function __construct(array $data)
    {
        if (!isset($data['administrator']) || !is_array($data['administrator'])) {
            throw new InvalidArgumentException('administrator data is required and must be an array');
        }
        $this->administrator = new Administrator($data['administrator']);

        if (!isset($data['definition']) || !is_array($data['definition'])) {
            throw new InvalidArgumentException('definition data is required and must be an array');
        }
        $this->definition = new AdminAttributeDefinition($data['definition']);

        $this->value = isset($data['value']) ? (string)$data['value'] : null;
    }
}
