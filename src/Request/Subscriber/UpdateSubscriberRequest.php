<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Subscriber;

use PhpList\RestApiClient\Request\AbstractRequest;

class UpdateSubscriberRequest extends AbstractRequest
{
    public string $email;
    public bool $confirmed = false;
    public bool $blacklisted = false;
    public bool $html_email = false;
    public bool $disabled = false;
    public ?string $additional_data = null;

    public function __construct(
        string $email,
        bool $confirmed = false,
        bool $blacklisted = false,
        bool $html_email = false,
        bool $disabled = false,
        ?string $additional_data = null
    ) {
        $this->email = $email;
        $this->confirmed = $confirmed;
        $this->blacklisted = $blacklisted;
        $this->html_email = $html_email;
        $this->disabled = $disabled;
        $this->additional_data = $additional_data;
    }
}
