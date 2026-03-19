<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Statistics;

use DateTimeImmutable;
use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity for a single campaign performance chart point.
 */
class CampaignPerformancePoint extends AbstractResponse
{
    public ?DateTimeImmutable $date;

    public int $opens;

    public int $clicks;

    public function __construct(array $data)
    {
        $this->date = !empty($data['date']) ? new DateTimeImmutable((string)$data['date']) : null;
        $this->opens = isset($data['opens']) ? (int)$data['opens'] : 0;
        $this->clicks = isset($data['clicks']) ? (int)$data['clicks'] : 0;
    }
}
