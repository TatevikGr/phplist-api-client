<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Admin;

use PhpList\RestApiClient\Request\AbstractRequest;

/**
 * Request class for creating a new administrator.
 */
class CreateAdministratorRequest extends AbstractRequest
{
    /**
     * @var string The login name
     */
    public string $loginName;

    /**
     * @var string The password
     */
    public string $password;

    /**
     * @var string The email address
     */
    public string $email;

    /**
     * @var bool Whether the administrator is a super user
     */
    public bool $superUser;

    /**
     * @var array|null The administrator privileges
     */
    public ?array $privileges = null;

    /**
     * CreateAdministratorRequest constructor.
     *
     * @param string $loginName The login name
     * @param string $password The password
     * @param string $email The email address
     * @param bool $superUser Whether the administrator is a super user
     * @param array|null $privileges The administrator privileges
     */
    public function __construct(
        string $loginName,
        string $password,
        string $email,
        bool $superUser,
        ?array $privileges = null
    ) {
        $this->loginName = $loginName;
        $this->password = $password;
        $this->email = $email;
        $this->superUser = $superUser;
        $this->privileges = $privileges;
    }
}
