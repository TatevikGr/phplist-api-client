<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Subscriber;

use PhpList\RestApiClient\Request\AbstractRequest;

class CreateSubscriberRequest extends AbstractRequest
{
    public string $email;
    public bool $requestConfirmation = false;
    public bool $htmlEmail = false;

    /**
     * @SuppressWarnings("BooleanArgumentFlag")
     */
    public function __construct(
        string $email,
        bool $requestConfirmation = false,
        bool $htmlEmail = false
    ) {
        $this->email = $email;
        $this->requestConfirmation = $requestConfirmation;
        $this->htmlEmail = $htmlEmail;
    }
}
