<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for a subscriber.
 */
class Subscriber extends AbstractResponse
{
    /**
     * @var int The subscriber ID
     */
    public int $id;

    /**
     * @var string The subscriber email
     */
    public string $email;

    /**
     * @var string The created date
     */
    public string $createdAt;

    /**
     * @var bool Whether the subscriber is confirmed
     */
    public bool $confirmed;

    /**
     * @var bool Whether the subscriber is blacklisted
     */
    public bool $blacklisted;

    /**
     * @var int The bounce count
     */
    public int $bounceCount;

    /**
     * @var string The unique identifier
     */
    public string $uniqueId;

    /**
     * @var bool Whether the subscriber prefers HTML email
     */
    public bool $htmlEmail;

    /**
     * @var bool Whether the subscriber is disabled
     */
    public bool $disabled;

    /**
     * @var array|null The subscribed lists
     */
    public ?array $subscribedLists = null;

    /**
     * @SuppressWarnings("CyclomaticComplexity")
     */
    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->email = isset($data['email']) ? (string)$data['email'] : '';
        $this->createdAt = isset($data['created_at']) ? (string)$data['created_at'] : '';
        $this->confirmed = isset($data['confirmed']) && (bool)$data['confirmed'];
        $this->blacklisted = isset($data['blacklisted']) && (bool)$data['blacklisted'];
        $this->bounceCount = isset($data['bounce_count']) ? (int)$data['bounce_count'] : 0;
        $this->uniqueId = isset($data['unique_id']) ? (string)$data['unique_id'] : '';
        $this->htmlEmail = isset($data['html_email']) && (bool)$data['html_email'];
        $this->disabled = isset($data['disabled']) && (bool)$data['disabled'];

        $this->subscribedLists = isset($data['subscribed_lists']) && is_array($data['subscribed_lists'])
            ? $data['subscribed_lists']
            : null;
    }
}
