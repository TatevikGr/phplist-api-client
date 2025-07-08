<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Message;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Value object for message metadata.
 */
class Metadata extends AbstractResponse
{
    /**
     * @var string|null The status of the message
     */
    public ?string $status = null;

    /**
     * @var bool|null Whether the message has been processed
     */
    public ?bool $processed = null;

    /**
     * @var int|null The number of views for the message
     */
    public ?int $views = null;

    /**
     * @var int|null The bounce count for the message
     */
    public ?int $bounceCount = null;

    /**
     * @var DateTimeInterface|null The date when the message was entered
     */
    public ?DateTimeInterface $entered = null;

    /**
     * @var DateTimeInterface|null The date when the message was sent
     */
    public ?DateTimeInterface $sent = null;

    /**
     * @throws Exception
     */
    public function __construct(array $data)
    {
        $this->status = isset($data['status']) ? (string)$data['status'] : null;
        $this->processed = isset($data['processed']) ? (bool)$data['processed'] : null;
        $this->views = isset($data['views']) ? (int)$data['views'] : null;
        $this->bounceCount = isset($data['bounce_count']) ? (int)$data['bounce_count'] : null;
        $this->entered = !empty($data['entered']) ? new DateTimeImmutable($data['entered']) : null;
        $this->sent = !empty($data['sent']) ? new DateTimeImmutable($data['sent']) : null;
    }
}
