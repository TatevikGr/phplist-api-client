<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\SubscribersClient;
use PhpList\RestApiClient\Entity\Subscriber;
use PhpList\RestApiClient\Entity\SubscriberHistory;
use PhpList\RestApiClient\Request\Subscriber\CreateSubscriberRequest;
use PhpList\RestApiClient\Request\Subscriber\UpdateSubscriberRequest;
use PhpList\RestApiClient\Request\Subscriber\ExportSubscriberRequest;
use PhpList\RestApiClient\Request\Subscriber\ImportSubscribersRequest;
use PhpList\RestApiClient\Request\Subscriber\GetSubscriberHistoryRequest;
use PhpList\RestApiClient\Response\Subscribers\SubscriberHistoryCollection;
use PHPUnit\Framework\TestCase;

class SubscribersClientTest extends TestCase
{
    private string $filePath;
    private SubscribersClient $subscribersClient;

    protected function setUp(): void
    {
        // Use Prism mock base URL by default if not provided
        $baseUrl = getenv('API_BASE_URL') ?: 'http://127.0.0.1:4010/';
        $client = new Client($baseUrl);

        // Only attempt login when credentials are provided via env
        $username = getenv('API_USERNAME') ?: '';
        $password = getenv('API_PASSWORD') ?: '';
        if ($username !== '' && $password !== '') {
            $client->login($username, $password);
        }
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

    public function testCanGetSubscriberHistory(): void
    {
        // Create a fresh subscriber to ensure we have a valid ID
        $uniqueEmail = 'history_' . uniqid('', true) . '@example.com';
        $createRequest = new CreateSubscriberRequest($uniqueEmail, true);
        $subscriber = $this->subscribersClient->createSubscriber($createRequest);
        $this->assertInstanceOf(Subscriber::class, $subscriber);

        // Fetch history with a small limit
        $filters = new GetSubscriberHistoryRequest(limit: 1);
        $history = $this->subscribersClient->getSubscriberHistory($subscriber->id, $filters);

        $this->assertInstanceOf(SubscriberHistoryCollection::class, $history);
        $this->assertIsArray($history->items);

        if (count($history->items) > 0) {
            $this->assertInstanceOf(SubscriberHistory::class, $history->items[0]);
            $this->assertIsInt($history->items[0]->id);
        }

        // Cleanup
        $this->subscribersClient->deleteSubscriber($subscriber->id);
        $this->assertTrue(true);
    }

    public function testCanConfirmSubscriber(): void
    {
        // Given a sample uniqueId, the Prism mock should return a 200 with text/html content type
        $uniqueId = 'e9d8c9b2e6';

        $response = $this->subscribersClient->confirmSubscriber($uniqueId);

        // We only assert that we received a string (raw body). It may be empty depending on the mock.
        $this->assertIsString($response);
    }

    public function testCanResetBounceCount(): void
    {
        // Create a subscriber
        $email = 'reset_bounce_' . uniqid('', true) . '@example.com';
        $createRequest = new CreateSubscriberRequest($email, true);
        $subscriber = $this->subscribersClient->createSubscriber($createRequest);
        $this->assertInstanceOf(Subscriber::class, $subscriber);

        // Reset bounce count
        $updated = $this->subscribersClient->resetBounceCount($subscriber->id);
        $this->assertInstanceOf(Subscriber::class, $updated);

        // Cleanup
        $this->subscribersClient->deleteSubscriber($subscriber->id);
        $this->assertTrue(true);
    }
}
