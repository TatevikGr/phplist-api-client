<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity representing a bounce record.
 */
class Bounce extends AbstractResponse
{
    public int $id;
    public ?string $status = null;
    public ?string $date = null;
    public int $messageId;
    public ?string $messageSubject = null;
    public ?int $subscriberId = null;
    public ?string $subscriberEmail = null;
    public ?string $comment = null;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->status = isset($data['status']) ? (string)$data['status'] : null;
        $this->date = isset($data['date']) ? (string)$data['date'] : null;
        $this->messageId = isset($data['message_id']) ? (int)$data['message_id'] : 0;
        $this->messageSubject = isset($data['message_subject']) ? (string)$data['message_subject'] : null;
        $this->subscriberId = isset($data['subscriber_id']) ? (int)$data['subscriber_id'] : null;
        $this->subscriberEmail = isset($data['subscriber_email']) ? (string)$data['subscriber_email'] : null;
        $this->comment = isset($data['comment']) ? (string)$data['comment'] : null;
    }
}
