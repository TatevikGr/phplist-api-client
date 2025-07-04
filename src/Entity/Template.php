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
}
