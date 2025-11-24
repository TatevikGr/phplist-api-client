<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Entity representing a bounce regex rule.
 */
class BounceRegex extends AbstractResponse
{
    public int $id;
    public string $regex;
    public string $regexHash;
    public ?string $action = null;
    public ?int $listOrder = null;
    public ?int $adminId = null;
    public ?string $comment = null;
    public ?string $status = null;
    public ?int $count = null;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->regex = isset($data['regex']) ? (string)$data['regex'] : '';
        $this->regexHash = isset($data['regex_hash']) ? (string)$data['regex_hash'] : '';
        $this->action = isset($data['action']) ? (string)$data['action'] : null;
        $this->listOrder = isset($data['list_order']) ? (int)$data['list_order'] : null;
        $this->adminId = isset($data['admin_id']) ? (int)$data['admin_id'] : null;
        $this->comment = isset($data['comment']) ? (string)$data['comment'] : null;
        $this->status = isset($data['status']) ? (string)$data['status'] : null;
        $this->count = isset($data['count']) ? (int)$data['count'] : null;
    }
}
