<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Entity\Message;

use PhpList\RestApiClient\Response\AbstractResponse;

/**
 * Value object for message format.
 */
class Format extends AbstractResponse
{
    /**
     * @var bool|null
     */
    public ?bool $htmlFormated = null;

    /**
     * @var string|null
     */
    public ?string $sendFormat = null;

    /**
     * @var array|null
     */
    public ?array $formatOptions = null;

    public function __construct(array $data)
    {
        $this->htmlFormated = isset($data['html_formated']) ? (bool)$data['html_formated'] : null;
        $this->sendFormat = isset($data['send_format']) ? (string)$data['send_format'] : null;
        $this->formatOptions = isset($data['format_options']) ? (array)$data['format_options'] : null;
    }
}
