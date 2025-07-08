<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Statistics;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for view/open statistics.
 */
class ViewOpen extends AbstractResponse
{
    /**
     * @var int The message ID
     */
    public int $campaignId;

    public string $subject;

    public int $sent;

    public ?int $uniqueViews = null;

    public ?float $rate = null;

    public function __construct(array $data)
    {
        $this->campaignId = isset($data['campaign_id']) ? (int)$data['campaign_id'] : 0;
        $this->subject = $data['subject'] ?? '';
        $this->sent = isset($data['sent']) ? (int)$data['sent'] : 0;
        $this->uniqueViews = isset($data['unique_views']) ? (int)$data['unique_views'] : 0;
        $this->rate = isset($data['rate']) ? (float)$data['rate'] : 0.0;
    }
}
