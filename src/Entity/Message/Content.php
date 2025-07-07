<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Message;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Value object for message content.
 */
class Content extends AbstractResponse
{
    /**
     * @var string|null The subject of the message
     */
    public ?string $subject = null;

    /**
     * @var string|null The HTML content of the message
     */
    public ?string $textMessage = null;

    /**
     * @var string|null The plain text content of the message
     */
    public ?string $text = null;

    /**
     * @var string|null The footer content of the message
     */
    public ?string $footer = null;

    public function __construct(array $data)
    {
        $this->subject = $data['subject'] ?? null;
        $this->textMessage = $data['text_message'] ?? null;
        $this->text = $data['text'] ?? null;
        $this->footer = $data['footer'] ?? null;
    }
}
