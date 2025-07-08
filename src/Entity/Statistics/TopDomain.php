<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Statistics;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for top domain statistics.
 */
class TopDomain extends AbstractResponse
{
    /**
     * @var string The domain name
     */
    public string $domain;

    /**
     * @var int The number of subscribers with this domain
     */
    public int $subscribers;

    /**
     * @var float The percentage of total subscribers
     */
    public float $percentage;

    public function __construct(array $data)
    {
        $this->domain = isset($data['domain']) ? (string)$data['domain'] : '';
        $this->subscribers = isset($data['subscribers']) ? (int)$data['subscribers'] : 0;
    }
}
