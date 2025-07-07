<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use Exception;
use PhpList\RestApiClient\Entity\Message\Content;
use PhpList\RestApiClient\Entity\Message\Format;
use PhpList\RestApiClient\Entity\Message\Schedule;
use PhpList\RestApiClient\Entity\Message\Metadata;
use PhpList\RestApiClient\Entity\Message\Options;
use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Response class for a campaign.
 */
class Campaign extends AbstractResponse
{
    /**
     * @var int The campaign ID
     */
    public int $id;

    /**
     * @var string The unique identifier of the campaign
     */
    public string $uniqueId;

    /**
     * @var Template|null The template used for the campaign
     */
    public ?Template $template = null;

    /**
     * @var Content|null The content of the message
     */
    public ?Content $messageContent = null;

    /**
     * @var Format|null The format of the message
     */
    public ?Format $messageFormat = null;

    /**
     * @var Metadata|null The metadata of the message
     */
    public ?Metadata $messageMetadata = null;

    /**
     * @var Schedule|null The schedule of the message
     */
    public ?Schedule $messageSchedule = null;

    /**
     * @var Options|null The options of the message
     */
    public ?Options $messageOptions = null;

    private const MAPPINGS = [
        'template'          => Template::class,
        'message_content'   => Content::class,
        'message_format'    => Format::class,
        'message_metadata'  => Metadata::class,
        'message_schedule'  => Schedule::class,
        'message_options'   => Options::class,
    ];

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        if ($this->template instanceof Template) {
            $data['template'] = $this->template->toArray();
        }

        if ($this->messageContent instanceof Content) {
            $data['message_content'] = $this->messageContent->toArray();
        }

        if ($this->messageFormat instanceof Format) {
            $data['message_format'] = $this->messageFormat->toArray();
        }

        if ($this->messageMetadata instanceof Metadata) {
            $data['message_metadata'] = $this->messageMetadata->toArray();
        }

        if ($this->messageSchedule instanceof Schedule) {
            $data['message_schedule'] = $this->messageSchedule->toArray();
        }

        if ($this->messageOptions instanceof Options) {
            $data['message_options'] = $this->messageOptions->toArray();
        }

        return $data;
    }

    /**
     * @param array $data
     * @throws Exception
     */
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (isset(self::MAPPINGS[$key]) && is_array($value)) {
                $class = self::MAPPINGS[$key];
                $this->$key = new $class($value);
            } elseif (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
