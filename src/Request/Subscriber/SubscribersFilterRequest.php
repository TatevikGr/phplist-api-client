<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Subscriber;

use PhpList\RestApiClient\Request\AbstractRequest;

class SubscribersFilterRequest extends AbstractRequest
{
    public ?bool $isConfirmed = null;
    public ?bool $isBlacklisted = null;
    public ?string $sortBy = null;
    public ?string $sortDirection = null;
    public ?string $findColumn = null;
    public ?string $findValue = null;

    public function __construct(
        ?bool $isConfirmed = null,
        ?bool $isBlacklisted = null,
        ?string $sortBy = null,
        ?string $sortDirection = null,
        ?string $findColumn = null,
        ?string $findValue = null
    ) {
        $this->isConfirmed = $isConfirmed;
        $this->isBlacklisted = $isBlacklisted;
        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;
        $this->findColumn = $findColumn;
        $this->findValue = $findValue;
    }
}
