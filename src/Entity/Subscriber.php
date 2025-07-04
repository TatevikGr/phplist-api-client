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
    public string $created_at;

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
    public int $bounce_count;

    /**
     * @var string The unique identifier
     */
    public string $unique_id;

    /**
     * @var bool Whether the subscriber prefers HTML email
     */
    public bool $html_email;

    /**
     * @var bool Whether the subscriber is disabled
     */
    public bool $disabled;

    /**
     * @var array|null The subscribed lists
     */
    public ?array $subscribed_lists = null;
}
