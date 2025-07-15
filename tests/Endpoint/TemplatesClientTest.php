<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\TemplatesClient;
use PhpList\RestApiClient\Response\TemplateCollection;

class TemplatesClientTest extends TestCase
{
    private Client $client;
    private TemplatesClient $templatesClient;

    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: 'http://localhost/api/v2/';
        $this->client = new Client($baseUrl);
        $this->templatesClient = new TemplatesClient($this->client);
    }

    public function testCanFetchTemplates(): void
    {
        $templates = $this->templatesClient->getTemplates();
        $this->assertInstanceOf(TemplateCollection::class, $templates);
        $this->assertNotEmpty($templates->items);
    }
}
