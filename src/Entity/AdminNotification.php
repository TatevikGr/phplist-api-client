<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity class for an in-app administrator notification.
 */
class AdminNotification extends AbstractResponse
{
    public string $code;
    public string $level;
    public string $message;
    public array $context;

    public function __construct(array $data)
    {
        $this->code = isset($data['code']) ? (string)$data['code'] : '';
        $this->level = isset($data['level']) ? (string)$data['level'] : '';
        $this->message = isset($data['message']) ? (string)$data['message'] : '';
        $this->context = isset($data['context']) && is_array($data['context']) ? $data['context'] : [];
    }
}
