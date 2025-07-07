<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;

/**
 * Client for templates-related API endpoints.
 */
class TemplatesClient
{
    /**
     * @var Client The API client
     */
    private Client $client;

    /**
     * TemplatesClient constructor.
     *
     * @param Client $client The API client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a list of templates.
     *
     * @param int|null $afterId The ID to start from for pagination
     * @param int $limit The maximum number of items to return
     * @return array The list of templates
     * @throws ApiException If an API error occurs
     */
    public function getTemplates(?int $afterId = null, int $limit = 25): array
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        return $this->client->get('templates', $queryParams);
    }

    /**
     * Get a template by ID.
     *
     * @param string $id The template ID
     * @return array The template data
     * @throws NotFoundException If the template is not found
     * @throws ApiException If an API error occurs
     */
    public function getTemplate(string $id): array
    {
        return $this->client->get('templates/' . $id);
    }

    /**
     * Create a new template.
     *
     * @param array $data The template data
     * @return array The created template
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function createTemplate(array $data): array
    {
        return $this->client->post('templates', $data);
    }

    /**
     * Delete a template.
     *
     * @param string $id The template ID
     * @return array The response data
     * @throws NotFoundException If the template is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteTemplate(string $id): array
    {
        return $this->client->delete('templates/' . $id);
    }
}
