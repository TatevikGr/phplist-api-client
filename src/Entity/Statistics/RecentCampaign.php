<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Statistics;

use DateTimeImmutable;
use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity for a recent campaign dashboard row.
 */
class RecentCampaign extends AbstractResponse
{
    public string $name;

    public ?string $status;

    public ?DateTimeImmutable $date;

    public string $openRate;

    public string $clickRate;

    public function __construct(array $data)
    {
        $this->name = isset($data['name']) ? (string)$data['name'] : '';
        $this->status = isset($data['status']) ? (string)$data['status'] : null;
        $this->date = !empty($data['date']) ? new DateTimeImmutable((string)$data['date']) : null;
        $this->openRate = isset($data['open_rate']) ? (string)$data['open_rate'] : '';
        $this->clickRate = isset($data['click_rate']) ? (string)$data['click_rate'] : '';
    }
}
