<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Statistics;

use DateTimeImmutable;
use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for campaign statistics.
 */
class CampaignStatistic extends AbstractResponse
{
    /**
     * @var int The campaign ID
     */
    public int $campaignId;

    /**
     * @var string The campaign subject
     */
    public string $subject;

    /**
     * @var int The number of sent messages
     */
    public int $sent;

    /**
     * @var ?DateTimeImmutable The campaign sent date
     */
    public ?DateTimeImmutable $dateSent;

    /**
     * @var int The number of bounces
     */
    public int $bounces;

    /**
     * @var int The number of forwards
     */
    public int $forwards;

    public int $uniqueViews;

    public int $totalClicks;

    public string $uniqueClicks;

    public function __construct(array $data)
    {
        $this->campaignId = (int)$data['campaign_id'];
        $this->subject = isset($data['subject']) ? (string)$data['subject'] : '';
        $this->dateSent = isset($data['date_sent']) ? new DateTimeImmutable($data['date_sent']) : null;
        $this->sent = (int)$data['sent'];
        $this->bounces = isset($data['bounces']) ? (int)$data['bounces'] : 0;
        $this->forwards = isset($data['forwards']) ? (int)$data['forwards'] : 0;
        $this->uniqueViews = isset($data['unique_views']) ? (float)$data['unique_views'] : 0;
        $this->totalClicks = isset($data['total_clicks']) ? (float)$data['total_clicks'] : 0;
        $this->uniqueClicks = isset($data['unique_clicks']) ? (string)$data['unique_clicks'] : 0;
    }
}
