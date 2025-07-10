<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Subscriber;

use PhpList\RestApiClient\Request\AbstractRequest;

class CreateSubscriberRequest extends AbstractRequest
{
    public string $email;
    public bool $request_confirmation = false;
    public bool $html_email = false;

    public function __construct(
        string $email,
        bool $request_confirmation = false,
        bool $html_email = false
    ) {
        $this->email = $email;
        $this->request_confirmation = $request_confirmation;
        $this->html_email = $html_email;
    }
}
