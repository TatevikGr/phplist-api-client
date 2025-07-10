<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Subscriber;

use PhpList\RestApiClient\Request\AbstractRequest;

class ImportSubscribersRequest extends AbstractRequest
{
    /** @var resource|string|null $file The uploaded CSV file (resource or file path for PHP file uploads) */
    public $file;

    /** @var int|null $list_id List id to add imported subscribers to */
    public ?int $list_id = null;

    /** @var bool $update_existing Whether to update existing subscribers or not */
    public bool $update_existing = false;

    public function __construct(
        $file,
        ?int $list_id = null,
        bool $update_existing = false
    ) {
        $this->file = $file;
        $this->list_id = $list_id;
        $this->update_existing = $update_existing;
    }
}
