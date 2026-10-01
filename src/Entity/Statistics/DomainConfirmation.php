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
     * @var DomainConfirmationBreakdown The confirmed subscribers breakdown
     */
    public DomainConfirmationBreakdown $confirmed;

    /**
     * @var DomainConfirmationBreakdown The unconfirmed subscribers breakdown
     */
    public DomainConfirmationBreakdown $unconfirmed;

    /**
     * @var DomainConfirmationBreakdown The blacklisted subscribers breakdown
     */
    public DomainConfirmationBreakdown $blacklisted;

    /**
     * @var DomainConfirmationBreakdown The total subscribers breakdown
     */
    public DomainConfirmationBreakdown $total;

    public function __construct(array $data)
    {
        $this->domain = isset($data['domain']) ? (string)$data['domain'] : '';
        $this->confirmed = new DomainConfirmationBreakdown($data['confirmed'] ?? []);
        $this->unconfirmed = new DomainConfirmationBreakdown($data['unconfirmed'] ?? []);
        $this->blacklisted = new DomainConfirmationBreakdown($data['blacklisted'] ?? []);
        $this->total = new DomainConfirmationBreakdown($data['total'] ?? []);
    }
}
