<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\SubscribePage;

use PhpList\RestApiClient\Request\AbstractRequest;

class PublicSubscriptionRequest extends AbstractRequest
{
    public string $email;
    public ?string $confirmEmail;
    public int $listId;
    public ?array $attributes;

    public function __construct(
        string $email,
        int $listId,
        ?string $confirmEmail = null,
        ?array $attributes = null
    ) {
        $this->email = $email;
        $this->confirmEmail = $confirmEmail;
        $this->listId = $listId;
        $this->attributes = $attributes;
    }
}
