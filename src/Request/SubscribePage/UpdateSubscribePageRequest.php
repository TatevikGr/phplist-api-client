<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\SubscribePage;

use PhpList\RestApiClient\Request\AbstractRequest;

class UpdateSubscribePageRequest extends AbstractRequest
{
    public ?string $title;
    public ?bool $active;

    public function __construct(?string $title = null, ?bool $active = null)
    {
        $this->title = $title;
        $this->active = $active;
    }
}
