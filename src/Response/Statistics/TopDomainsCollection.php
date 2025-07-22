<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response\Statistics;

use PhpList\RestApiClient\Entity\Statistics\TopDomain;

/**
 * Response class for a collection of top domain statistics.
 */
class TopDomainsCollection
{
    /**
     * @var TopDomain[] The list of top domain statistics
     */
    public array $domains = [];
    public int $total;

    public function __construct(array $data)
    {
        $this->total = (int)$data['total'];
        foreach ($data['domains'] as $item) {
            $this->domains[] = new TopDomain($item);
        }
    }
}
