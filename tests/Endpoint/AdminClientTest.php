<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Exception\AuthenticationException;
use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\AdminClient;
use PhpList\RestApiClient\Response\Admin\AdministratorCollection;
use PhpList\RestApiClient\Entity\Administrator;
use PhpList\RestApiClient\Request\Admin\CreateAdministratorRequest;
use PhpList\RestApiClient\Request\Admin\UpdateAdministratorRequest;
use PhpList\RestApiClient\Response\DeleteResponse;

class AdminClientTest extends TestCase
{
    private AdminClient $adminClient;

    /**
     * @throws AuthenticationException
     */
    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $client = new Client($baseUrl);
        $client->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->adminClient = new AdminClient($client);
    }

    public function testCanFetchAdministrators(): void
    {
        $administrators = $this->adminClient->getAdministrators();
        $this->assertInstanceOf(AdministratorCollection::class, $administrators);
    }

    public function testCanFetchAdministrator(): void
    {
        $administrator = $this->adminClient->getAdministrator(1);
        $this->assertInstanceOf(Administrator::class, $administrator);
    }

    public function testCanCreateUpdateAndDeleteAdministrator(): void
    {
        $uniqueId = uniqid();
        $loginName = 'admin';
        $email = 'admin@example.com';
        
        $createRequest = new CreateAdministratorRequest(
            $loginName,
            'password123',
            $email,
            true
        );
        
        $createdAdmin = $this->adminClient->createAdministrator($createRequest);
        $this->assertInstanceOf(Administrator::class, $createdAdmin);
        $this->assertEquals($loginName, $createdAdmin->loginName);
        $this->assertEquals($email, $createdAdmin->email);
        $this->assertEquals(true, $createdAdmin->superUser);
        
        $fetchedAdmin = $this->adminClient->getAdministrator($createdAdmin->id);
        $this->assertInstanceOf(Administrator::class, $fetchedAdmin);
        $this->assertEquals($createdAdmin->id, $fetchedAdmin->id);
        
        $updatedEmail = 'admin@example.com';
        $updateRequest = new UpdateAdministratorRequest(
            null,
            null,
            $updatedEmail,
            true
        );

        $updatedAdmin = $this->adminClient->updateAdministrator(
            $createdAdmin->id,
            $updateRequest
        );
        $this->assertInstanceOf(Administrator::class, $updatedAdmin);
        $this->assertEquals($updatedEmail, $updatedAdmin->email);
        $this->assertEquals(true, $updatedAdmin->superUser);
        
        $deleteResponse = $this->adminClient->deleteAdministrator($createdAdmin->id);
        $this->assertInstanceOf(DeleteResponse::class, $deleteResponse);
        $this->assertTrue($deleteResponse->success);
    }
}
