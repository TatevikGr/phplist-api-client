<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request;

class CreateConfigRequest extends AbstractRequest
{
    public string $key;
    public string $value;
    public ?bool $editable = null;

    public function __construct(string $key, string $value, ?bool $editable = null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->editable = $editable;
    }
}
