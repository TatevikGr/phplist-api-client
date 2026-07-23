<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for a configuration.
 */
class Config extends AbstractResponse
{
    public string $key;
    public string $value;
    public bool $editable;
    public string $type;

    public function __construct(array $data)
    {
        $this->key = isset($data['key']) ? (string)$data['key'] : '';
        $this->value = isset($data['value']) ? (string)$data['value'] : '';
        $this->editable = isset($data['editable']) && (bool)$data['editable'];
    }
}
