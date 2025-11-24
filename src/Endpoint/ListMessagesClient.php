<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Response\Subscribers\SubscriberListCollection;

/**
 * Client for message/list association endpoints.
 */
class ListMessagesClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns a list of subscriber lists associated with a message.
     *
     * GET /api/v2/list-messages/message/{messageId}/lists
     *
     * @throws ApiException
     */
    public function getListsByMessage(int $messageId): SubscriberListCollection
    {
        $response = $this->client->get('list-messages/message/' . $messageId . '/lists');
        return new SubscriberListCollection($response);
    }

    /**
     * Removes all list associations for a message.
     *
     * DELETE /api/v2/list-messages/message/{messageId}/lists
     *
     * @throws ApiException
     */
    public function removeAllListsFromMessage(int $messageId): void
    {
        $this->client->delete('list-messages/message/' . $messageId . '/lists');
    }

    /**
     * Returns a list of messages associated with a subscriber list.
     * The response shape is not strictly modeled here; raw array is returned.
     *
     * GET /api/v2/list-messages/list/{listId}/messages
     *
     * @return array
     * @throws ApiException
     */
    public function getMessagesByList(int $listId): array
    {
        return $this->client->get('list-messages/list/' . $listId . '/messages');
    }

    /**
     * Associates a message with a subscriber list.
     *
     * POST /api/v2/list-messages/message/{messageId}/list/{listId}
     *
     * @return array Raw API response
     * @throws ApiException
     */
    public function associateMessageWithList(int $messageId, int $listId): array
    {
        return $this->client->post('list-messages/message/' . $messageId . '/list/' . $listId);
    }

    /**
     * Disassociates a message from a subscriber list.
     *
     * DELETE /api/v2/list-messages/message/{messageId}/list/{listId}
     *
     * @throws ApiException
     */
    public function dissociateMessageFromList(int $messageId, int $listId): void
    {
        $this->client->delete('list-messages/message/' . $messageId . '/list/' . $listId);
    }

    /**
     * Checks if a message is associated with a subscriber list.
     *
     * GET /api/v2/list-messages/message/{messageId}/list/{listId}/check
     *
     * @return bool True if associated, false otherwise
     * @throws ApiException
     */
    public function checkMessageAssociatedWithList(int $messageId, int $listId): bool
    {
        $response = $this->client->get('list-messages/message/' . $messageId . '/list/' . $listId . '/check');
        return (bool)($response['is_associated'] ?? false);
    }
}
