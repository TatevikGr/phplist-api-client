<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\SubscribersClient;
use PhpList\RestApiClient\Entity\Subscriber;
use PhpList\RestApiClient\Request\Subscriber\CreateSubscriberRequest;
use PhpList\RestApiClient\Request\Subscriber\UpdateSubscriberRequest;
use PhpList\RestApiClient\Request\Subscriber\ExportSubscriberRequest;
use PhpList\RestApiClient\Request\Subscriber\ImportSubscribersRequest;
use PHPUnit\Framework\TestCase;

class SubscribersClientTest extends TestCase
{
    private string $filePath;
    private SubscribersClient $subscribersClient;

    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $client = new Client($baseUrl);
        $client->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->subscribersClient = new SubscribersClient($client);
        $this->filePath = tempnam(sys_get_temp_dir(), 'import');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
        }
    }

    public function testCanCreateGetUpdateAndDeleteSubscriber(): void
    {
        $createRequest = new CreateSubscriberRequest(
            'subscriber@example.com',
            true
        );
        $subscriber = $this->subscribersClient->createSubscriber($createRequest);
        $this->assertInstanceOf(Subscriber::class, $subscriber);
        $this->assertEquals($createRequest->email, $subscriber->email);

        $fetched = $this->subscribersClient->getSubscriber($subscriber->id);
        $this->assertInstanceOf(Subscriber::class, $fetched);
        $this->assertEquals($subscriber->id, $fetched->id);

        $updateRequest = new UpdateSubscriberRequest('subscriber@example.com');
        $updated = $this->subscribersClient->updateSubscriber($subscriber->id, $updateRequest);
        $this->assertInstanceOf(Subscriber::class, $updated);
        $this->assertEquals($updateRequest->email, $updated->email);

        $this->subscribersClient->deleteSubscriber($subscriber->id);
        $this->assertTrue(true);
    }

    public function testCanExportSubscribers(): void
    {
        $filters = new ExportSubscriberRequest();

        $exported = $this->subscribersClient->exportSubscribers($filters);
        $this->assertIsArray($exported);
    }

    public function testCanImportSubscribers(): void
    {
        $csvData = "email,name\n" .
            'imported_" . uniqid() . "@example.com,Imported User\n';

        file_put_contents($this->filePath, $csvData);

        $listId = getenv('API_TEST_LIST_ID') ?: 1;

        $importRequest = new ImportSubscribersRequest(
            fopen($this->filePath, 'r'),
            $listId,
            true
        );

        $imported = $this->subscribersClient->importSubscribers($importRequest);
        $this->assertIsArray($imported);
    }
}
