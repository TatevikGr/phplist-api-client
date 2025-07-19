<?php

declare(strict_types=1);

namespace PhpList\RestApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use PhpList\RestApiClient\Exception\ApiException;
use PhpList\RestApiClient\Exception\AuthenticationException;
use PhpList\RestApiClient\Exception\NotFoundException;
use PhpList\RestApiClient\Exception\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Main client class for interacting with the phpList REST API.
 */
class Client
{
    /**
     * @var GuzzleClient The HTTP client used to make requests
     */
    private GuzzleClient $httpClient;

    /**
     * @var string|null The session ID for authenticated requests
     */
    private ?string $sessionId = null;

    /**
     * @var LoggerInterface The logger instance
     */
    private LoggerInterface $logger;

    /**
     * @var string The base URL for the API
     */
    private string $baseUrl;

    /**
     * Client constructor.
     *
     * @param string $baseUrl The base URL for the API (e.g., 'https://example.com')
     * @param array $config Additional configuration options for the HTTP client
     * @param LoggerInterface|null $logger Logger instance
     */
    public function __construct(
        string $baseUrl,
        array $config = [],
        ?LoggerInterface $logger = null
    ) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->logger = $logger ?? new NullLogger();

        $defaultConfig = [
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
            'http_errors' => false,
        ];

        $this->httpClient = new GuzzleClient(array_merge($defaultConfig, $config));
    }

    /**
     * Authenticate with the API using login credentials.
     *
     * @param string $username The username
     * @param string $password The password
     * @return array The authentication response data
     * @throws AuthenticationException If authentication fails or an API error occurs
     */
    public function login(string $username, string $password): array
    {
        $this->logger->info('Authenticating with the API', ['username' => $username]);

        try {
            $response = $this->httpClient->post('api/v2/sessions', [
                'json' => [
                    'login_name' => $username,
                    'password' => $password,
                ],
            ]);

            $data = $this->handleResponse($response);

            if (isset($data['key'])) {
                $this->sessionId = $data['key'];
                $this->logger->info('Successfully authenticated with the API');
            } else {
                throw new AuthenticationException('Session ID not found in response');
            }

            return $data;
        } catch (GuzzleException $e) {
            $this->logger->error('Authentication failed', ['error' => $e->getMessage()]);
            throw new AuthenticationException('Failed to authenticate: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Set the session ID for authenticated requests.
     *
     * @param string $sessionId The session ID
     * @return self
     */
    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    /**
     * Get the current session ID.
     *
     * @return string|null The session ID or null if not set
     */
    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    /**
     * Make a GET request to the API.
     *
     * @param string $endpoint The API endpoint
     * @param array $queryParams Query parameters
     * @return array The response data
     * @throws ApiException If an API error occurs
     */
    public function get(string $endpoint, array $queryParams = []): array
    {
        return $this->request('GET', $endpoint, ['query' => $queryParams]);
    }

    /**
     * Make a POST request to the API.
     *
     * @param string $endpoint The API endpoint
     * @param array $data The request data
     * @return array The response data
     * @throws ApiException If an API error occurs
     */
    public function post(string $endpoint, array $data = []): array
    {
        return $this->request('POST', $endpoint, ['json' => $data]);
    }

    /**
     * Make a PUT request to the API.
     *
     * @param string $endpoint The API endpoint
     * @param array $data The request data
     * @return array The response data
     * @throws ApiException If an API error occurs
     */
    public function put(string $endpoint, array $data = []): array
    {
        return $this->request('PUT', $endpoint, ['json' => $data]);
    }

    /**
     * Make a DELETE request to the API.
     *
     * @param string $endpoint The API endpoint
     * @return array The response data
     * @throws ApiException If an API error occurs
     */
    public function delete(string $endpoint, array $queryParams = []): array
    {
        return $this->request('DELETE', $endpoint, ['query' => $queryParams]);
    }

    /**
     * Make a request to the API.
     *
     * @param string $method The HTTP method
     * @param string $endpoint The API endpoint
     * @param array $options Request options
     * @return array The response data
     * @throws ApiException If an API error occurs
     */
    private function request(string $method, string $endpoint, array $options = []): array
    {
        $endpoint = ltrim($endpoint, '/');
        $url = '/api/v2/' . $endpoint;

        if ($this->sessionId) {
            $options['headers'] = $options['headers'] ?? [];
            $options['headers']['php-auth-pw'] = $this->sessionId;
        }

        $this->logger->info('Making API request', [
            'method' => $method,
            'url' => $url,
            'options' => $options,
        ]);

        try {
            $response = $this->httpClient->request($method, $url, $options);
            return $this->handleResponse($response);
        } catch (GuzzleException $e) {
            $this->logger->error('API request failed', ['error' => $e->getMessage()]);
            throw new ApiException('API request failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * @throws ApiException
     */
    public function postMultipart(string $endpoint, array $multipart): array
    {
        return $this->request('POST', $endpoint, ['multipart' => $multipart]);
    }

    /**
     * Handle the API response.
     *
     * @param ResponseInterface $response The HTTP response
     * @return array The response data
     * @throws ApiException If an API error occurs
     * @throws AuthenticationException If authentication fails
     * @throws NotFoundException If the resource is not found
     * @throws ValidationException If validation fails
     */
    private function handleResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        $body = (string) $response->getBody();
        $data = json_decode($body, true) ?? [];

        $this->logger->debug('API response received', [
            'status_code' => $statusCode,
            'body' => $body,
        ]);

        if ($statusCode >= 200 && $statusCode < 300) {
            $data['success'] = true;
            return $data;
        }

        $this->handleErrorResponse($statusCode, $data);
    }

    /**
     * Handle error responses by throwing appropriate exceptions.
     *
     * @param int $statusCode The HTTP status code
     * @param array $data The response data
     * @return never
     * @throws ApiException If an API error occurs
     * @throws AuthenticationException If authentication fails
     * @throws NotFoundException If the resource is not found
     * @throws ValidationException If validation fails
     */
    private function handleErrorResponse(int $statusCode, array $data): never
    {
        throw match ($statusCode) {
            401, 403 => new AuthenticationException($data['message'] ?? 'Authentication failed', $statusCode),
            404 => new NotFoundException($data['message'] ?? 'Resource not found', $statusCode),
            400,422 => new ValidationException(
                message: $data['message'] ?? 'Validation failed',
                statusCode: $statusCode,
                errors: $data['errors'] ?? []
            ),
            default => new ApiException(
                message: $data['message'] ?? 'API error occurred',
                statusCode: $statusCode
            ),
        };
    }
}
