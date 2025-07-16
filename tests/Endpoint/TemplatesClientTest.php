<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Exception\AuthenticationException;
use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\TemplatesClient;
use PhpList\RestApiClient\Response\TemplateCollection;

class TemplatesClientTest extends TestCase
{
    private Client $client;
    private TemplatesClient $templatesClient;

    /**
     * @throws AuthenticationException
     */
    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $this->client = new Client($baseUrl);
        $this->client->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->templatesClient = new TemplatesClient($this->client);
    }

    public function testCanFetchTemplates(): void
    {
        $templates = $this->templatesClient->getTemplates();
        $this->assertInstanceOf(TemplateCollection::class, $templates);
        $this->assertNotEmpty($templates->items);
    }
}
