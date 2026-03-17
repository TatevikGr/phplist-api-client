<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Subscriber;

use PhpList\RestApiClient\Request\AbstractRequest;

class UpdateSubscriberRequest extends AbstractRequest
{
    public string $email;
    public bool $confirmed = false;
    public bool $blacklisted = false;
    public bool $htmlEmail = false;
    public bool $disabled = false;

    /**
     * @SuppressWarnings("BooleanArgumentFlag")
     */
    public function __construct(
        string $email,
        bool $confirmed = false,
        bool $blacklisted = false,
        bool $htmlEmail = false,
        bool $disabled = false
    ) {
        $this->email = $email;
        $this->confirmed = $confirmed;
        $this->blacklisted = $blacklisted;
        $this->htmlEmail = $htmlEmail;
        $this->disabled = $disabled;
    }
}
