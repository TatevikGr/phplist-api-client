<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Statistics;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for domain confirmation statistics.
 */
class DomainConfirmation extends AbstractResponse
{
    /**
     * @var string The domain name
     */
    public string $domain;

    /**
     * @var int The total number of subscribers with this domain
     */
    public int $total;

    /**
     * @var int The number of confirmed subscribers
     */
    public int $confirmed;

    /**
     * @var int The number of unconfirmed subscribers
     */
    public int $unconfirmed;

    /**
     * @var float The confirmation rate (percentage)
     */
    public float $confirmationRate;

    public function __construct(array $data)
    {
        $this->domain = isset($data['domain']) ? (string)$data['domain'] : '';
        $this->total = isset($data['total']) ? (int)$data['total'] : 0;
        $this->confirmed = isset($data['confirmed']) ? (int)$data['confirmed'] : 0;
        $this->unconfirmed = isset($data['unconfirmed']) ? (int)$data['unconfirmed'] : 0;
        $this->confirmationRate = isset($data['confirmation_rate']) ? (float)$data['confirmation_rate'] : 0.0;
    }
}
