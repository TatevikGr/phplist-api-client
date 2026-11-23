<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Campaign;

use PhpList\RestApiClient\Request\AbstractRequest;

/**
 * Request class for updating campaign message data. Only non-null fields are sent.
 */
class UpdateMessageDataRequest extends AbstractRequest
{
    public ?bool $googleTrack = null;
    public ?string $utmSource = null;
    public ?string $utmMedium = null;
    public ?string $utmCampaign = null;
    public ?string $pkSource = null;
    public ?string $pkMedium = null;
    public ?string $pkCampaign = null;
    public ?string $notifyStart = null;
    public ?string $notifyEnd = null;
    /** @var int[]|null */
    public ?array $excludeLists = null;
}
