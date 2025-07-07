<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Response class for template.
 */
class Template extends AbstractResponse
{
    /**
     * @var int The template ID
     */
    public int $id;

    /**
     * @var string The template title
     */
    public string $title;

    /**
     * @var ?string The template description
     */
    public ?string $text = null;

    /**
     * @var ?string The template content
     */
    public ?string $content = null;

    /**
     * @var string|null
     */
    public ?string $order = null;

    /**
     * @var ?array
     */
    public ?array $images = null;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : 0;
        $this->title = isset($data['title']) ? (string)$data['title'] : '';
        $this->text = isset($data['text']) ? (string)$data['text'] : null;
        $this->content = isset($data['content']) ? (string)$data['content'] : null;
        $this->order = isset($data['order']) ? (string)$data['order'] : null;

        $this->images  = isset($data['images']) && is_array($data['images']) ? $data['images'] : null;
    }
}
