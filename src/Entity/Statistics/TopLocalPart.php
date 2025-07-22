<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Statistics;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for top local part statistics.
 */
class TopLocalPart extends AbstractResponse
{
    /**
     * @var string The local part (part before @ in email)
     */
    public string $localPart;

    /**
     * @var int The number of subscribers with this local part
     */
    public int $count;

    /**
     * @var float The percentage of total subscribers
     */
    public float $percentage;

    public function __construct(array $data)
    {
        $this->localPart = isset($data['local_part']) ? (string)$data['local_part'] : '';
        $this->count = isset($data['count']) ? (int)$data['count'] : 0;
        $this->percentage = isset($data['percentage']) ? (float)$data['percentage'] : 0.0;
    }
}
