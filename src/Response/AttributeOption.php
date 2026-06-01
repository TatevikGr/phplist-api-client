<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Response;

class AttributeOption
{
    public int $id;
    public string $name;
    public int $listOrder;

    public function __construct(array $data)
    {
        $this->id = (int)$data['id'] ?? 0;
        $this->name = $data['name'] ?? '';
        $this->listOrder = (int)$data['list_order'] ?? 0;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'list_order' => $this->listOrder,
        ];
    }
}
