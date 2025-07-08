<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Entity\Template;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;
use PhpList\RestApiClient\Request\Template\CreateTemplateRequest;
use PhpList\RestApiClient\Response\DeleteResponse;
use PhpList\RestApiClient\Response\TemplateCollection;

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
     * @return TemplateCollection The list of templates
     * @throws ApiException If an API error occurs
     */
    public function getTemplates(?int $afterId = null, int $limit = 25): TemplateCollection
    {
        $queryParams = ['limit' => $limit];

        if ($afterId !== null) {
            $queryParams['after_id'] = $afterId;
        }

        $response = $this->client->get('templates', $queryParams);
        return new TemplateCollection($response);
    }

    /**
     * Get a template by ID.
     *
     * @param string $id The template ID
     * @return Template The template data
     * @throws NotFoundException If the template is not found
     * @throws ApiException If an API error occurs
     */
    public function getTemplate(string $id): Template
    {
        $response = $this->client->get('templates/' . $id);
        return new Template($response);
    }

    /**
     * Create a new template.
     *
     * @param CreateTemplateRequest $request The template request
     * @return Template The created template
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function createTemplate(CreateTemplateRequest $request): Template
    {
        $response = $this->client->post('templates', $request->toArray());
        return new Template($response);
    }

    /**
     * Delete a template.
     *
     * @param string $id The template ID
     * @return DeleteResponse The response data
     * @throws NotFoundException If the template is not found
     * @throws ApiException If an API error occurs
     */
    public function deleteTemplate(string $id): DeleteResponse
    {
        $response = $this->client->delete('templates/' . $id);
        return new DeleteResponse($response);
    }
}
