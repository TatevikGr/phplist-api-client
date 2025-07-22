<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Admin;

use PhpList\RestApiClient\Request\AbstractRequest;

/**
 * Request class for updating an administrator.
 */
class UpdateAdministratorRequest extends AbstractRequest
{
    /**
     * @var string|null The login name
     */
    public ?string $loginName = null;

    /**
     * @var string|null The password
     */
    public ?string $password = null;

    /**
     * @var string|null The email address
     */
    public ?string $email = null;

    /**
     * @var bool|null Whether the administrator is a super user
     */
    public ?bool $superUser = null;

    /**
     * @var array|null The administrator privileges
     */
    public ?array $privileges = null;

    /**
     * UpdateAdministratorRequest constructor.
     *
     * @param string|null $loginName The login name
     * @param string|null $password The password
     * @param string|null $email The email address
     * @param bool|null $superUser Whether the administrator is a super user
     * @param array|null $privileges The administrator privileges
     */
    public function __construct(
        ?string $loginName = null,
        ?string $password = null,
        ?string $email = null,
        ?bool $superUser = null,
        ?array $privileges = null
    ) {
        $this->loginName = $loginName;
        $this->password = $password;
        $this->email = $email;
        $this->superUser = $superUser;
        $this->privileges = $privileges;
    }
}
