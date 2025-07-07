<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Message;

use DateTimeImmutable;
use DateTimeInterface;
use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Value object for message schedule.
 */
class Schedule extends AbstractResponse
{
    /**
     * @var int|null
     */
    public ?int $repeatInterval = null;

    /**
     * @var DateTimeInterface|null The scheduled end date of the message
     */
    public ?DateTimeInterface $repeatUntil = null;

    /**
     * @var int|null The repeat frequency of the message
     */
    public ?int $requeueInterval = null;

    /**
     * @var DateTimeInterface|null
     */
    public ?DateTimeInterface $requeueUntil = null;

    /**
     * @var DateTimeInterface|null
     */
    public ?DateTimeInterface $embargo = null;

    public function __construct(array $data)
    {
        $this->repeatInterval = isset($data['repeat_interval']) ? (int)$data['repeat_interval'] : null;

        $this->repeatUntil = isset($data['repeat_until'])
            ? new DateTimeImmutable($data['repeat_until'])
            : null;

        $this->requeueInterval = isset($data['requeue_interval']) ? (int)$data['requeue_interval'] : null;

        $this->requeueUntil = isset($data['requeue_until'])
            ? new DateTimeImmutable($data['requeue_until'])
            : null;

        $this->embargo = isset($data['embargo'])
            ? new DateTimeImmutable($data['embargo'])
            : null;
    }
}
