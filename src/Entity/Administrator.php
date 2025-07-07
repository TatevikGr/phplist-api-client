<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;
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
    public string $loginName;

    /**
     * @var string The email address
     */
    public string $email;

    /**
     * @var bool Whether the administrator is a super user
     */
    public bool $superUser;

    /**
     * @var DateTimeInterface The creation date
     */
    public DateTimeInterface $createdAt;

    /**
     * @throws Exception
     */
    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->loginName = isset($data['login_name']) ? (string)$data['login_name'] : '';
        $this->email = isset($data['email']) ? (string)$data['email'] : '';
        $this->superUser = isset($data['super_user']) && (bool)$data['super_user'];

        if (empty($data['created_at'])) {
            throw new InvalidArgumentException('created_at is required');
        }
        $this->createdAt  = new DateTimeImmutable($data['created_at']);
    }
}
