<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for a subscriber history.
 */
class SubscriberHistory extends AbstractResponse
{
    /**
     * @var int The history record ID
     */
    public int $id;

    /**
     * @var string The IP address associated with the event
     */
    public string $ip;

    /**
     * @var string The creation timestamp (ISO 8601)
     */
    public string $createdAt;

    /**
     * @var string Short summary of the event
     */
    public string $summary;

    /**
     * @var string Detailed description of the event
     */
    public string $detail;

    /**
     * @var string Additional system information
     */
    public string $systemInfo;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->ip = isset($data['ip']) ? (string)$data['ip'] : '';
        $this->createdAt = isset($data['created_at']) ? (string)$data['created_at'] : '';
        $this->summary = isset($data['summary']) ? (string)$data['summary'] : '';
        $this->detail = isset($data['detail']) ? (string)$data['detail'] : '';
        $this->systemInfo = isset($data['system_info']) ? (string)$data['system_info'] : '';
    }
}
