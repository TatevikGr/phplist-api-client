<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;

/**
 * Client for editor uploads API endpoints.
 */
class UploadsClient
{
    /**
     * @var Client The API client
     */
    private Client $client;

    /**
     * UploadsClient constructor.
     *
     * @param Client $client The API client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List files in an upload directory.
     *
     * @param string $directory Upload directory (e.g. uploads, images)
     * @return array Response containing files, directory and total
     * @throws NotFoundException If the directory does not exist
     * @throws ApiException If an API error occurs
     */
    public function getUploads(string $directory = 'uploads'): array
    {
        return $this->client->get('editor-uploads', [
            'directory' => $directory,
        ]);
    }

    /**
     * Upload an editor asset.
     *
     * Accepts either an uploaded file path or a CURLFile, depending on the
     * Client implementation.
     *
     * @param mixed $file File to upload
     * @param string $field Form field name ("upload" or "file")
     * @return array Uploaded file information
     * @throws ValidationException If validation fails
     * @throws ApiException If an API error occurs
     */
    public function upload(mixed $file, string $field = 'upload'): array
    {
        $multipart = [
            [
                'name' => $field,
                'contents' => fopen($file, 'rb'),
                'filename' => basename($file),
            ],
        ];

        return $this->client->postMultipart(
            'editor-uploads',
            $multipart,
        );
    }
}
