<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

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
}
