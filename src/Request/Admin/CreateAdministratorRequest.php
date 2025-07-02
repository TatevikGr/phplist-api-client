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
    public string $login_name;

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
    public bool $super_user;

    /**
     * @var array|null The administrator privileges
     */
    public ?array $privileges = null;

    /**
     * CreateAdministratorRequest constructor.
     *
     * @param string $login_name The login name
     * @param string $password The password
     * @param string $email The email address
     * @param bool $super_user Whether the administrator is a super user
     * @param array|null $privileges The administrator privileges
     */
    public function __construct(
        string $login_name,
        string $password,
        string $email,
        bool $super_user,
        ?array $privileges = null
    ) {
        $this->login_name = $login_name;
        $this->password = $password;
        $this->email = $email;
        $this->super_user = $super_user;
        $this->privileges = $privileges;
    }
}
