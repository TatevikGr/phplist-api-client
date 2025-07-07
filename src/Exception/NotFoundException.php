<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Exception;

use Throwable;

/**
 * Exception thrown when a requested resource is not found.
 */
class NotFoundException extends ApiException
{
}
