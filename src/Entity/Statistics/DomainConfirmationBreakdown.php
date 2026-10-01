<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Statistics;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for a confirmed/unconfirmed/blacklisted/total count-and-percentage breakdown.
 */
class DomainConfirmationBreakdown extends AbstractResponse
{
    /**
     * @var int The number of subscribers in this breakdown
     */
    public int $count;

    /**
     * @var float The percentage of total subscribers
     */
    public float $percentage;

    public function __construct(array $data)
    {
        $this->count = isset($data['count']) ? (int)$data['count'] : 0;
        $this->percentage = isset($data['percentage']) ? (float)$data['percentage'] : 0.0;
    }
}
