<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

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
    public string $unique_id;

    /**
     * @var Template|null The template used for the campaign
     */
    public ?Template $template = null;

    /**
     * @var array|null The content of the message
     */
    public ?array $message_content = null;

    /**
     * @var array|null The format of the message
     */
    public ?array $message_format = null;

    /**
     * @var array|null The metadata of the message
     */
    public ?array $message_metadata = null;

    /**
     * @var array|null The schedule of the message
     */
    public ?array $message_schedule = null;

    /**
     * @var array|null The options of the message
     */
    public ?array $message_options = null;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        // Convert a Template object to array if it exists
        if ($this->template instanceof Template) {
            $data['template'] = $this->template->toArray();
        }

        return $data;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): self
    {
        $instance = new static();

        foreach ($data as $key => $value) {
            if ($key === 'template' && is_array($value)) {
                $instance->template = Template::fromArray($value);
            } elseif (property_exists($instance, $key)) {
                $instance->$key = $value;
            }
        }

        return $instance;
    }
}
