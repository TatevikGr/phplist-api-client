<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Campaign;

use PhpList\RestApiClient\Request\AbstractRequest;

/**
 * Request class for updating a campaign.
 */
class UpdateCampaignRequest extends AbstractRequest
{
    /**
     * @var array|null The content of the campaign (subject, body)
     */
    public ?array $content = null;

    /**
     * @var array|null The format of the campaign (html, text)
     */
    public ?array $format = null;

    /**
     * @var array|null The metadata of the campaign (title, description)
     */
    public ?array $metadata = null;

    /**
     * @var array|null The schedule of the campaign (send_at)
     */
    public ?array $schedule = null;

    /**
     * @var array|null The options of the campaign (track_opens, track_clicks)
     */
    public ?array $options = null;

    /**
     * UpdateCampaignRequest constructor.
     *
     * @param array|null $content The content of the campaign (subject, body)
     * @param array|null $format The format of the campaign (html, text)
     * @param array|null $metadata The metadata of the campaign (title, description)
     * @param array|null $schedule The schedule of the campaign (send_at)
     * @param array|null $options The options of the campaign (track_opens, track_clicks)
     */
    public function __construct(
        ?array $content = null,
        ?array $format = null,
        ?array $metadata = null,
        ?array $schedule = null,
        ?array $options = null
    ) {
        $this->content = $content;
        $this->format = $format;
        $this->metadata = $metadata;
        $this->schedule = $schedule;
        $this->options = $options;
    }
}
