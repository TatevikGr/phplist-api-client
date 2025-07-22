<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Exception\AuthenticationException;
use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\AdminAttributeClient;
use PhpList\RestApiClient\Response\Admin\AdminAttributeDefinitionCollection;
use PhpList\RestApiClient\Response\Admin\AdminAttributeValueCollection;
use PhpList\RestApiClient\Entity\AdminAttributeDefinition;
use PhpList\RestApiClient\Entity\AdminAttributeValue;
use PhpList\RestApiClient\Request\Admin\CreateAdminAttributeDefinitionRequest;
use PhpList\RestApiClient\Request\Admin\UpdateAdminAttributeDefinitionRequest;

class AdminAttributeClientTest extends TestCase
{
    private AdminAttributeClient $adminAttributeClient;

    /**
     * @throws AuthenticationException
     */
    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $client = new Client($baseUrl);
        $client->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->adminAttributeClient = new AdminAttributeClient($client);
    }

    public function testCanFetchAttributeDefinitions(): void
    {
        $attributeDefinitions = $this->adminAttributeClient->getAttributeDefinitions();
        $this->assertInstanceOf(AdminAttributeDefinitionCollection::class, $attributeDefinitions);
    }

    public function testCanFetchAttributeValues(): void
    {
        $attributeValues = $this->adminAttributeClient->getAttributeValues(1);
        $this->assertInstanceOf(AdminAttributeValueCollection::class, $attributeValues);
    }

    public function testCanCreateUpdateAndDeleteAttributeDefinition(): void
    {
        $createRequest = new CreateAdminAttributeDefinitionRequest(
            'Country',
            'textline',
        );
        
        $createdDefinition = $this->adminAttributeClient->createAttributeDefinition($createRequest);
        $this->assertInstanceOf(AdminAttributeDefinition::class, $createdDefinition);
        $this->assertEquals($createRequest->name, $createdDefinition->name);
        
        $fetchedDefinition = $this->adminAttributeClient->getAttributeDefinition($createdDefinition->id);
        $this->assertInstanceOf(AdminAttributeDefinition::class, $fetchedDefinition);
        $this->assertEquals($createdDefinition->id, $fetchedDefinition->id);
        
        $updateRequest = new UpdateAdminAttributeDefinitionRequest('Country', 'textline');

        $updatedDefinition = $this->adminAttributeClient->updateAttributeDefinition(
            $createdDefinition->id,
            $updateRequest,
        );
        $this->assertInstanceOf(AdminAttributeDefinition::class, $updatedDefinition);
        $this->assertEquals($updateRequest->name, $updatedDefinition->name);
        
        $this->adminAttributeClient->deleteAttributeDefinition($createdDefinition->id);
        $this->assertTrue(true);
    }

    public function testCanSetAndDeleteAttributeValue(): void
    {
        $createRequest = new CreateAdminAttributeDefinitionRequest(
            'Test Value Attribute ' . uniqid(),
            'textline',
        );

        $definition = $this->adminAttributeClient->createAttributeDefinition($createRequest);

        $adminId = 1;
        $testValue = 'United States';

        $setValue = $this->adminAttributeClient->setAttributeValue($adminId, $definition->id, $testValue);
        $this->assertInstanceOf(AdminAttributeValue::class, $setValue);
        $this->assertEquals($testValue, $setValue->value);
        
        $getValue = $this->adminAttributeClient->getAttributeValue($adminId, $definition->id);
        $this->assertInstanceOf(AdminAttributeValue::class, $getValue);
        $this->assertEquals($testValue, $getValue->value);

        $this->adminAttributeClient->deleteAttributeValue($adminId, $definition->id);
        $this->adminAttributeClient->deleteAttributeDefinition($definition->id);
        $this->assertTrue(true);
    }
}
