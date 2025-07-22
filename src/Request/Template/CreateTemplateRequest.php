<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Request\Template;

use PhpList\RestApiClient\Request\AbstractRequest;

/**
 * Request class for creating a new template.
 */
class CreateTemplateRequest extends AbstractRequest
{
    /**
     * @var string The title of the template
     */
    public string $title;

    /**
     * @var string|null The HTML content of the template
     */
    public ?string $content = null;

    /**
     * @var string|null The plain text content of the template
     */
    public ?string $text = null;

    /**
     * @var string|null Optional file upload for HTML content
     */
    public ?string $file = null;

    /**
     * @var bool|null Check that all links have full URLs
     */
    public ?bool $checkLinks = null;

    /**
     * @var bool|null Check that all images have full URLs
     */
    public ?bool $checkImages = null;

    /**
     * @var bool|null Check that all external images exist
     */
    public ?bool $checkExternalImages = null;

    /**
     * CreateTemplateRequest constructor.
     *
     * @param string $title The title of the template
     * @param string|null $content The HTML content of the template
     * @param string|null $text The plain text content of the template
     * @param string|null $file Optional file upload for HTML content
     * @param bool|null $checkLinks Check that all links have full URLs
     * @param bool|null $checkImages Check that all images have full URLs
     * @param bool|null $checkExternalImages Check that all external images exist
     */
    public function __construct(
        string $title,
        ?string $content = null,
        ?string $text = null,
        ?string $file = null,
        ?bool $checkLinks = null,
        ?bool $checkImages = null,
        ?bool $checkExternalImages = null
    ) {
        $this->title = $title;
        $this->content = $content;
        $this->text = $text;
        $this->file = $file;
        $this->checkLinks = $checkLinks;
        $this->checkImages = $checkImages;
        $this->checkExternalImages = $checkExternalImages;
    }
}
