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
        $this->googleTrack = self::toBool($data, 'google_track');
        $this->utmSource = self::nullableString($data, 'utm_source');
        $this->utmMedium = self::nullableString($data, 'utm_medium');
        $this->utmCampaign = self::nullableString($data, 'utm_campaign');
        $this->pkSource = self::nullableString($data, 'pk_source');
        $this->pkMedium = self::nullableString($data, 'pk_medium');
        $this->pkCampaign = self::nullableString($data, 'pk_campaign');
        $this->notifyStart = self::nullableString($data, 'notify_start');
        $this->notifyEnd = self::nullableString($data, 'notify_end');
        $this->excludeLists = self::intList($data, 'exclude_lists');
    }

    private static function toBool(array $data, string $key): bool
    {
        return isset($data[$key]) && (bool)$data[$key];
    }

    private static function nullableString(array $data, string $key): ?string
    {
        $value = $data[$key] ?? null;

        return $value === null ? null : (string)$value;
    }

    /**
     * @return int[]
     */
    private static function intList(array $data, string $key): array
    {
        $value = $data[$key] ?? [];

        return is_array($value) ? array_map('intval', $value) : [];
    }
}
