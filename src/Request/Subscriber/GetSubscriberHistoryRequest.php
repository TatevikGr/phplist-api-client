<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Subscriber;

use PhpList\RestApiClient\Request\AbstractRequest;

class GetSubscriberHistoryRequest extends AbstractRequest
{
    /**
     * Page cursor: return items after this ID
     */
    public ?int $afterId = null;

    /**
     * Max items per page
     */
    public ?int $limit = null;

    /**
     * Filter by IP address
     */
    public ?string $ip = null;

    /**
     * Filter by date (format: Y-m-d)
     */
    public ?string $dateFrom = null;

    /**
     * Filter by summary text (note: API uses the key "summery")
     */
    public ?string $summery = null;

    public function __construct(
        ?int $afterId = null,
        ?int $limit = null,
        ?string $ip = null,
        ?string $dateFrom = null,
        ?string $summery = null,
    ) {
        $this->afterId = $afterId;
        $this->limit = $limit;
        $this->ip = $ip;
        $this->dateFrom = $dateFrom;
        $this->summery = $summery;
    }
}
