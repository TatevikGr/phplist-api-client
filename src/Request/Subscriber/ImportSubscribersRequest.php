<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Subscriber;

use PhpList\RestApiClient\Request\AbstractRequest;

class ImportSubscribersRequest extends AbstractRequest
{
    /** @var resource|string|null $file The uploaded CSV file (resource or file path for PHP file uploads) */
    public $file;

    /** @var int|null $listId List id to add imported subscribers to */
    public ?int $listId = null;

    /** @var bool $updateExisting Whether to update existing subscribers or not */
    public bool $updateExisting = false;

    public bool $skipInvalidEmails = false;

    /**
     * @SuppressWarnings("BooleanArgumentFlag")
     */
    public function __construct(
        $file,
        ?int $listId = null,
        bool $updateExisting = false,
        bool $skipInvalidEmails = false
    ) {
        $this->file = $file;
        $this->listId = $listId;
        $this->updateExisting = $updateExisting;
        $this->skipInvalidEmails = $skipInvalidEmails;
    }
}
