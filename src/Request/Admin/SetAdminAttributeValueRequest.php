<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Admin;

use PhpList\RestApiClient\Request\AbstractRequest;

/**
 * Request class for setting an administrator attribute value.
 */
class SetAdminAttributeValueRequest extends AbstractRequest
{
    /**
     * @var string The attribute value
     */
    public string $value;

    /**
     * SetAdminAttributeValueRequest constructor.
     *
     * @param string $value The attribute value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
