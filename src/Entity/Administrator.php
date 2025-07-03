<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Response class for administrator.
 */
class Administrator extends AbstractResponse
{
    /**
     * @var int The administrator ID
     */
    public int $id;

    /**
     * @var string The login name
     */
    public string $login_name;

    /**
     * @var string The email address
     */
    public string $email;

    /**
     * @var bool Whether the administrator is a super user
     */
    public bool $super_user;

    /**
     * @var string The creation date
     */
    public string $created_at;
}
