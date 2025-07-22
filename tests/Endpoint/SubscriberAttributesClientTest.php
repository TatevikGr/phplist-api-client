<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\SubscriberAttributesClient;
use PhpList\RestApiClient\Exception\AuthenticationException;
use PhpList\RestApiClient\Entity\SubscriberAttributeDefinition;
use PhpList\RestApiClient\Entity\SubscriberAttributeValue;
use PhpList\RestApiClient\Request\SubscriberAttribute\CreateSubscriberAttributeDefinitionRequest;
use PhpList\RestApiClient\Request\SubscriberAttribute\UpdateSubscriberAttributeDefinitionRequest;
use PhpList\RestApiClient\Response\SubscriberAttributes\SubscriberAttributeCollection;
use PhpList\RestApiClient\Response\SubscriberAttributes\SubscriberAttributeValueCollection;
use PHPUnit\Framework\TestCase;

class SubscriberAttributesClientTest extends TestCase
{
    private SubscriberAttributesClient $subscriberAttributesClient;
    private int $testSubscriberId = 1;

    /**
     * @throws AuthenticationException
     */
    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $client = new Client($baseUrl);
        $client->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->subscriberAttributesClient = new SubscriberAttributesClient($client);
    }

    public function testCanFetchAttributeDefinitions(): void
    {
        $attributeDefinitions = $this->subscriberAttributesClient->getAttributeDefinitions();
        $this->assertInstanceOf(SubscriberAttributeCollection::class, $attributeDefinitions);
    }

    public function testCanFetchAttributeValues(): void
    {
        $attributeValues = $this->subscriberAttributesClient->getAttributeValues($this->testSubscriberId);
        $this->assertInstanceOf(SubscriberAttributeValueCollection::class, $attributeValues);
    }

    public function testCanCreateUpdateAndDeleteAttributeDefinition(): void
    {
        $createRequest = new CreateSubscriberAttributeDefinitionRequest(
            'Country',
            'textline'
        );
        $createdDefinition = $this->subscriberAttributesClient->createAttributeDefinition($createRequest);
        $this->assertInstanceOf(SubscriberAttributeDefinition::class, $createdDefinition);
        $this->assertEquals($createRequest->name, $createdDefinition->name);

        $fetchedDefinition = $this->subscriberAttributesClient->getAttributeDefinition($createdDefinition->id);
        $this->assertInstanceOf(SubscriberAttributeDefinition::class, $fetchedDefinition);
        $this->assertEquals($createdDefinition->id, $fetchedDefinition->id);

        $updateRequest = new UpdateSubscriberAttributeDefinitionRequest(
            'Country',
            'textline'
        );
        $updatedDefinition = $this->subscriberAttributesClient->updateAttributeDefinition(
            $createdDefinition->id,
            $updateRequest
        );
        $this->assertInstanceOf(SubscriberAttributeDefinition::class, $updatedDefinition);
        $this->assertEquals($updateRequest->name, $updatedDefinition->name);

        $this->subscriberAttributesClient->deleteAttributeDefinition($createdDefinition->id);
        $this->assertTrue(true);
    }

    public function testCanSetAndDeleteAttributeValue(): void
    {
        $createRequest = new CreateSubscriberAttributeDefinitionRequest(
            'Country',
            'textline'
        );
        $definition = $this->subscriberAttributesClient->createAttributeDefinition($createRequest);

        $testValue = 'United States';

        $setValue = $this->subscriberAttributesClient->setAttributeValue(
            $this->testSubscriberId,
            $definition->id,
            $testValue
        );
        $this->assertInstanceOf(SubscriberAttributeValue::class, $setValue);
        $this->assertEquals($testValue, $setValue->value);

        $getValue = $this->subscriberAttributesClient->getAttributeValue(
            $this->testSubscriberId,
            $definition->id
        );
        $this->assertInstanceOf(SubscriberAttributeValue::class, $getValue);
        $this->assertEquals($testValue, $getValue->value);

        $this->subscriberAttributesClient->deleteAttributeValue($this->testSubscriberId, $definition->id);
        $this->subscriberAttributesClient->deleteAttributeDefinition($definition->id);
        $this->assertTrue(true);
    }
}
