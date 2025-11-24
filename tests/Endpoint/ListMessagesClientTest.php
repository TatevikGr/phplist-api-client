<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\ListMessagesClient;
use PhpList\RestApiClient\Response\Subscribers\SubscriberListCollection;
use PhpList\RestApiClient\Entity\SubscriberList;
use PHPUnit\Framework\TestCase;

class ListMessagesClientTest extends TestCase
{
    private ListMessagesClient $listMessagesClient;

    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $client = new Client($baseUrl);
        // Authenticate to ensure php-auth-pw header is included where required
        $client->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));

        $this->listMessagesClient = new ListMessagesClient($client);
    }

    public function testGetListsByMessage(): void
    {
        $messageId = 1;
        $lists = $this->listMessagesClient->getListsByMessage($messageId);

        $this->assertInstanceOf(SubscriberListCollection::class, $lists);
        $this->assertIsArray($lists->items);
        if (count($lists->items) > 0) {
            $this->assertInstanceOf(SubscriberList::class, $lists->items[0]);
        }
    }

    public function testRemoveAllListsFromMessage(): void
    {
        $messageId = 1;
        $this->listMessagesClient->removeAllListsFromMessage($messageId);
        // success if no exception
        $this->assertTrue(true);
    }

    public function testGetMessagesByList(): void
    {
        $listId = 1;
        $result = $this->listMessagesClient->getMessagesByList($listId);

        $this->assertIsArray($result);
        if (array_key_exists('items', $result)) {
            $this->assertIsArray($result['items']);
        }
    }

    public function testAssociateAndDissociateMessageWithList(): void
    {
        $messageId = 1;
        $listId = 1;

        $associate = $this->listMessagesClient->associateMessageWithList($messageId, $listId);
        $this->assertIsArray($associate);

        // Now dissociate; no exception means success
        $this->listMessagesClient->dissociateMessageFromList($messageId, $listId);
        $this->assertTrue(true);
    }

    public function testCheckMessageAssociatedWithList(): void
    {
        $messageId = 1;
        $listId = 1;

        $isAssociated = $this->listMessagesClient->checkMessageAssociatedWithList($messageId, $listId);
        $this->assertIsBool($isAssociated);
    }
}
