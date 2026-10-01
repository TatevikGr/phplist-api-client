<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Campaign;

use DateTimeImmutable;
use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity for a campaign stuck in processing.
 */
class StuckCampaign extends AbstractResponse
{
    public int $id;

    public string $subject;

    public string $status;

    public ?DateTimeImmutable $updatedAt;

    public int $stuckSeconds;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->subject = isset($data['subject']) ? (string)$data['subject'] : '';
        $this->status = isset($data['status']) ? (string)$data['status'] : '';
        $this->updatedAt = !empty($data['updated_at']) ? new DateTimeImmutable((string)$data['updated_at']) : null;
        $this->stuckSeconds = isset($data['stuck_seconds']) ? (int)$data['stuck_seconds'] : 0;
    }
}
