<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Subscriber;

use PhpList\RestApiClient\Request\AbstractRequest;

class ExportSubscriberRequest extends AbstractRequest
{
    public string $dateType = 'any';
    public ?int $listId = null;
    public ?string $dateFrom = null;
    public ?string $dateTo = null;
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
        string $dateType = 'any',
        ?int $listId = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
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
        $this->dateType = $dateType;
        $this->listId = $listId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->columns = $columns;
    }
}
