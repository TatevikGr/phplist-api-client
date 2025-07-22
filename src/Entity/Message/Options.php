<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Message;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Value object for message options.
 */
class Options extends AbstractResponse
{
    /**
     * @var string|null The from field of the message
     */
    public ?string $fromField = null;

    /**
     * @var string|null The to field of the message
     */
    public ?string $toField = null;

    /**
     * @var string|null The reply-to address of the message
     */
    public ?string $replyTo = null;

    /**
     * @var string|null The user selection for the message
     */
    public ?string $userSelection = null;

    public function __construct(array $data)
    {
        $this->fromField = $data['from_field'] ?? null;
        $this->toField = $data['to_field'] ?? null;
        $this->replyTo = $data['reply_to'] ?? null;
        $this->userSelection = $data['user_selection'] ?? null;
    }
}
