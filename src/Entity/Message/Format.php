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
     * @var int
     */
    public int $asText;

    /**
     * @var int
     */
    public int $asHtml;

    public function __construct(array $data)
    {
        $this->htmlFormated = isset($data['html_formated']) ? (bool)$data['html_formated'] : null;
        $this->sendFormat = isset($data['send_format']) ? (string)$data['send_format'] : null;
        $this->asText = (int)$data['as_text'];
        $this->asHtml = (int)$data['as_html'];
    }
}
