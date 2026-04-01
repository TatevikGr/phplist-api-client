<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Entity\Subscriber;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Request\Subscriber\CreateSubscriberRequest;
use PhpList\RestApiClient\Request\Subscriber\ExportSubscriberRequest;
use PhpList\RestApiClient\Request\Subscriber\GetSubscriberHistoryRequest;
use PhpList\RestApiClient\Request\Subscriber\ImportSubscribersRequest;
use PhpList\RestApiClient\Request\Subscriber\SubscribersFilterRequest;
use PhpList\RestApiClient\Request\Subscriber\UpdateSubscriberRequest;
use PhpList\RestApiClient\Response\Subscribers\SubscriberHistoryCollection;
use PhpList\RestApiClient\Response\Subscribers\SubscriberCollection;
use Psr\Http\Message\ResponseInterface;

/**
 * Client for subscriber-related API endpoints.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class SubscribersClient
{
    /**
     * @var Client The API client
     */
    private Client $client;

    /**
     * SubscribersClient constructor.
     *
     * @param Client $client The API client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a subscriber by ID.
     *
     * @param int $id The subscriber ID
     * @return Subscriber The subscriber data
     * @throws NotFoundException If the subscriber is not found
     * @throws ApiException If an API error occurs
     */
    public function getSubscriber(int $id): Subscriber
    {
        $response = $this->client->get('subscribers/' . $id);
        return new Subscriber($response);
    }

    /**
     * Create a new subscriber.
     *
     * @param CreateSubscriberRequest $request
     * @return Subscriber The created subscriber
     * @throws ApiException If an API error occurs
     */
    public function createSubscriber(CreateSubscriberRequest $request): Subscriber
    {
        $response = $this->client->post('subscribers', $request->toArray());
        return new Subscriber($response);
    }

    /**
     * Update a subscriber.
     *
     * @param int $id The subscriber ID
     * @param UpdateSubscriberRequest $request
     * @return Subscriber The updated subscriber
     * @throws ApiException If an API error occurs
     */
    public function updateSubscriber(int $id, UpdateSubscriberRequest $request): Subscriber
    {
        $response = $this->client->put('subscribers/' . $id, $request->toArray());
        return new Subscriber($response);
    }

    /**
     * Delete a subscriber.
     *
     * @param int $id The subscriber ID
     * @throws NotFoundException If the subscriber is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteSubscriber(int $id): void
    {
        $this->client->delete('subscribers/' . $id);
    }

    /**
     * Export subscribers.
     *
     * @param ExportSubscriberRequest|null $filters Filters to apply to the export
     * @return ResponseInterface The export data
     */
    public function exportSubscribers(?ExportSubscriberRequest $filters = null): ResponseInterface
    {
        return $this->client->postRawResponse('subscribers/export', $filters?->toArray() ?? []);
    }

    /**
     * Import subscribers.
     *
     * @param ImportSubscribersRequest $data The import data
     * @return array The import result
     * @throws ApiException If an API error occurs
     */
    public function importSubscribers(ImportSubscribersRequest $data): array
    {
        $multipart = [
            [
                'name' => 'file',
                'contents' => $data->file,
            ],
            [
                'name' => 'list_id',
                'contents' => $data->listId,
            ],
            [
                'name' => 'update_existing',
                'contents' => $data->updateExisting ? '1' : '0',
            ],
        ];

        return $this->client->postMultipart('subscribers/import', $multipart);
    }

    /**
     * Get a subscriber history by filter.
     *
     * @param int $id The subscriber ID
     * @return SubscriberHistoryCollection The subscriber history data
     * @throws NotFoundException If the subscriber is not found
     * @throws ApiException If an API error occurs
     */
    public function getSubscriberHistory(
        int $id,
        ?GetSubscriberHistoryRequest $filters = null
    ): SubscriberHistoryCollection {
        $query = $filters ? $filters->toArray() : [];
        $response = $this->client->get('subscribers/' . $id .'/history', $query);
        return new SubscriberHistoryCollection($response);
    }

    /**
     * Confirm a subscriber by uniqueId.
     *
     * This endpoint returns text/html content. The raw string response is returned as-is.
     *
     * @param string $uniqueId Unique identifier for the subscriber confirmation
     * @return string Raw HTML/text response from the API
     * @throws ApiException If an API error occurs or the subscriber is not found/invalid
     */
    public function confirmSubscriber(string $uniqueId): string
    {
        return $this->client->getRaw('subscribers/confirm', [
            'uniqueId' => $uniqueId,
        ]);
    }

    /**
     * Gets a paginated list of subscribers.
     *
     * @param SubscribersFilterRequest $request Filter parameters for subscribers
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return SubscriberCollection The list of subscribers
     * @throws ApiException If an API error occurs
     */
    public function getSubscribers(
        SubscribersFilterRequest $request,
        ?int $afterId = null,
        int $limit = 25
    ): SubscriberCollection {
        $queryParams = array_merge($request->toArray(), [
            'limit' => $limit,
        ]);

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        $response = $this->client->get('subscribers', $queryParams);
        return new SubscriberCollection($response);
    }

    /**
     * Reset bounce count for a subscriber and return the updated subscriber.
     *
     * POST /api/v2/subscribers/{subscriberId}/reset-bounce-count
     *
     * @param int $subscriberId The subscriber ID
     * @return Subscriber Updated subscriber data
     * @throws ApiException If an API error occurs
     */
    public function resetBounceCount(int $subscriberId): Subscriber
    {
        $response = $this->client->post('subscribers/' . $subscriberId . '/reset-bounce-count', []);
        return new Subscriber($response);
    }
}
