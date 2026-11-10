<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Campaign;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for campaign settings that are not part of the campaign itself.
 */
class MessageData extends AbstractResponse
{
    public bool $googleTrack;
    public ?string $utmSource;
    public ?string $utmMedium;
    public ?string $utmCampaign;
    public ?string $pkSource;
    public ?string $pkMedium;
    public ?string $pkCampaign;
    public ?string $notifyStart;
    public ?string $notifyEnd;
    /** @var int[] */
    public array $excludeLists;

    public function __construct(array $data)
    {
        $this->googleTrack = isset($data['google_track']) && (bool)$data['google_track'];
        $this->utmSource = self::nullableString($data['utm_source'] ?? null);
        $this->utmMedium = self::nullableString($data['utm_medium'] ?? null);
        $this->utmCampaign = self::nullableString($data['utm_campaign'] ?? null);
        $this->pkSource = self::nullableString($data['pk_source'] ?? null);
        $this->pkMedium = self::nullableString($data['pk_medium'] ?? null);
        $this->pkCampaign = self::nullableString($data['pk_campaign'] ?? null);
        $this->notifyStart = self::nullableString($data['notify_start'] ?? null);
        $this->notifyEnd = self::nullableString($data['notify_end'] ?? null);
        $excluded = $data['exclude_lists'] ?? [];
        $this->excludeLists = is_array($excluded) ? array_map('intval', $excluded) : [];
    }

    private static function nullableString(mixed $value): ?string
    {
        return $value === null ? null : (string)$value;
    }
}
