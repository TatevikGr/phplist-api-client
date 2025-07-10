<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Subscriber;

use PhpList\RestApiClient\Request\AbstractRequest;

class ExportSubscriberRequest extends AbstractRequest
{
    public string $date_type = 'any';
    public ?int $list_id = null;
    public ?string $date_from = null;
    public ?string $date_to = null;
    public array $columns = [
        'id',
        'email',
        'confirmed',
        'blacklisted',
        'bounceCount',
        'createdAt',
        'updatedAt',
        'uniqueId',
        'htmlEmail',
        'disabled',
        'extraData'
    ];

    public function __construct(
        string $date_type = 'any',
        ?int $list_id = null,
        ?string $date_from = null,
        ?string $date_to = null,
        array $columns = [
            'id',
            'email',
            'confirmed',
            'blacklisted',
            'bounceCount',
            'createdAt',
            'updatedAt',
            'uniqueId',
            'htmlEmail',
            'disabled',
            'extraData'
        ]
    ) {
        $this->date_type = $date_type;
        $this->list_id = $list_id;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->columns = $columns;
    }
}
