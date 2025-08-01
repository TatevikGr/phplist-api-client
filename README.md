# phpList REST API Client

A PHP client library for interacting with the phpList REST API.

## Installation

You can install the library via Composer:

```bash
composer require phplist/rest-api-client
```

## Requirements

- PHP 8.1 or higher
- Composer
- GuzzleHTTP 7.0 or higher

## Basic Usage

### Initialization

You can initialize the client like this:

```php
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\AdminClient;
use PhpList\RestApiClient\Endpoint\CampaignClient;
use PhpList\RestApiClient\Endpoint\AuthClient;
use PhpList\RestApiClient\Endpoint\SubscriptionClient;
use PhpList\RestApiClient\Endpoint\StatisticsClient;

// Create the main client
$client = new Client('https://your-phplist-api-url.com');

// Create endpoint clients
$adminClient = new AdminClient($client);
$authClient = new AuthClient($client);
$campaignClient = new CampaignClient($client);
$subscriptionClient = new SubscriptionClient($client);
$statisticsClient = new StatisticsClient($client);
```

### Authentication

```php
try {
    // Login and get a session
    $session = $authClient->login('username', 'password');

    // The session ID is automatically stored in the client for subsequent requests
    echo "Logged in with session ID: " . $client->getSessionId();

    // Get the current user
    $currentUser = $authClient->getCurrentUser();
    echo "Current user: " . $currentUser['username'];

    // Logout when done
    $authClient->logout();
} catch (\PhpList\RestApiClient\Exception\AuthenticationException $e) {
    echo "Authentication failed: " . $e->getMessage();
} catch (\PhpList\RestApiClient\Exception\ApiException $e) {
    echo "API error: " . $e->getMessage();
}
```

### Working with Campaigns

```php
try {
    // Get a list of campaigns
    $campaigns = $campaignClient->getCampaigns();

    // Get a specific campaign
    $campaign = $campaignClient->getCampaign(123);

    // Create a new campaign
    $createRequest = new \PhpList\RestApiClient\Request\Campaign\CreateCampaignRequest(
        [
            'subject' => 'New Campaign',
            'body' => '<p>Hello, world!</p>',
        ],
        [
            'html' => true,
            'text' => true,
        ],
        [
            'title' => 'My Campaign',
            'description' => 'A test campaign',
        ],
        [
            'send_at' => '2023-12-31 12:00:00',
        ],
        [
            'track_opens' => true,
            'track_clicks' => true,
        ]
    );
    $newCampaign = $campaignClient->createCampaign($createRequest);

    // Update a campaign
    $updateRequest = new \PhpList\RestApiClient\Request\Campaign\UpdateCampaignRequest(
        [
            'subject' => 'Updated Campaign',
        ]
    );
    $updatedCampaign = $campaignClient->updateCampaign(123, $updateRequest);

    // Delete a campaign
    $campaignClient->deleteCampaign(123);
} catch (\PhpList\RestApiClient\Exception\NotFoundException $e) {
    echo "Campaign not found: " . $e->getMessage();
} catch (\PhpList\RestApiClient\Exception\ValidationException $e) {
    echo "Validation error: " . $e->getMessage();
    print_r($e->getErrors());
} catch (\PhpList\RestApiClient\Exception\ApiException $e) {
    echo "API error: " . $e->getMessage();
}
```

### Working with Subscribers and Lists

```php
try {
    // Get a list of subscribers
    $subscribers = $subscriptionClient->getSubscribers();

    // Get a specific subscriber
    $subscriber = $subscriptionClient->getSubscriber(456);

    // Create a new subscriber
    $newSubscriber = $subscriptionClient->createSubscriber([
        'email' => 'user@example.com',
        'confirmed' => true,
        'blacklisted' => false,
        'attributes' => [
            'name' => 'John Doe',
        ],
    ]);

    // Get a list of subscriber lists
    $lists = $subscriptionClient->getSubscriberLists();

    // Add a subscriber to a list
    $subscriptionClient->addSubscriberToList(456, 789);

    // Remove a subscriber from a list
    $subscriptionClient->removeSubscriberFromList(456, 789);
} catch (\PhpList\RestApiClient\Exception\ApiException $e) {
    echo "API error: " . $e->getMessage();
}
```

### Working with Administrators

```php
try {
    // Get a list of administrators
    $administrators = $adminClient->getAdministrators();

    // Get a specific administrator
    $administrator = $adminClient->getAdministrator(123);

    // Create a new administrator
    $createRequest = new \PhpList\RestApiClient\Request\Admin\CreateAdministratorRequest(
        'admin',
        'securepassword',
        'admin@example.com',
        false,
        ['subscribers' => true, 'campaigns' => true]
    );
    $newAdministrator = $adminClient->createAdministrator($createRequest);

    // Update an administrator
    $updateRequest = new \PhpList\RestApiClient\Request\Admin\UpdateAdministratorRequest(
        'admin', // login_name
        null,    // password (not updating)
        'updated.admin@example.com' // email
    );
    $updatedAdministrator = $adminClient->updateAdministrator(123, $updateRequest);

    // Delete an administrator
    $adminClient->deleteAdministrator(123);

    // Get administrator attribute definitions
    $attributeDefinitions = $adminClient->getAttributeDefinitions();

    // Get a specific attribute definition
    $attributeDefinition = $adminClient->getAttributeDefinition(456);

    // Create a new attribute definition
    $attrRequest = new \PhpList\RestApiClient\Request\Admin\CreateAdminAttributeDefinitionRequest(
        'department',
        'text',
        10, // order
        '', // default_value
        false // required
    );
    $newAttributeDefinition = $adminClient->createAttributeDefinition($attrRequest);

    // Get attribute values for an administrator
    $attributeValues = $adminClient->getAttributeValues(123);

    // Get a specific attribute value
    $attributeValue = $adminClient->getAttributeValue(123, 456);
} catch (\PhpList\RestApiClient\Exception\ApiException $e) {
    echo "API error: " . $e->getMessage();
}
```

### Working with Statistics

```php
try {
    // Get campaign statistics
    $campaignStats = $statisticsClient->getCampaignStatistics();

    // Get statistics for a specific campaign
    $specificCampaignStats = $statisticsClient->getCampaignStatistics(123);

    // Get subscriber statistics
    $subscriberStats = $statisticsClient->getSubscriberStatistics();

    // Get system statistics
    $systemStats = $statisticsClient->getSystemStatistics();

    // Get statistics for a specific time period
    $timeStats = $statisticsClient->getTimePeriodStatistics('2023-01-01', '2023-12-31');
} catch (\PhpList\RestApiClient\Exception\ApiException $e) {
    echo "API error: " . $e->getMessage();
}
```

## Error Handling

The client throws different types of exceptions based on the error:

- `ApiException`: Base exception for all API errors
- `AuthenticationException`: Thrown when authentication fails
- `NotFoundException`: Thrown when a requested resource is not found
- `ValidationException`: Thrown when validation fails for API requests

```php
try {
    // Make API calls
} catch (\PhpList\RestApiClient\Exception\AuthenticationException $e) {
    // Handle authentication errors
    echo "Authentication error: " . $e->getMessage();
} catch (\PhpList\RestApiClient\Exception\NotFoundException $e) {
    // Handle not found errors
    echo "Not found: " . $e->getMessage();
} catch (\PhpList\RestApiClient\Exception\ValidationException $e) {
    // Handle validation errors
    echo "Validation error: " . $e->getMessage();

    // Get all validation errors
    $errors = $e->getErrors();

    // Check for errors on a specific field
    if ($e->hasErrorsForField('email')) {
        $emailErrors = $e->getErrorsForField('email');
        echo "Email errors: " . implode(', ', $emailErrors);
    }
} catch (\PhpList\RestApiClient\Exception\ApiException $e) {
    // Handle other API errors
    echo "API error: " . $e->getMessage();
    echo "Status code: " . $e->getStatusCode();
}
```

## Logging

You can provide a PSR-3 compatible logger to the client for logging requests and responses:

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PhpList\RestApiClient\Client;

// Create a logger
$logger = new Logger('api_client');
$logger->pushHandler(new StreamHandler('path/to/your.log', Logger::DEBUG));

// Create the client with the logger
$client = new Client('https://your-phplist-api-url.com', [], $logger);
```

## Testing

The library includes unit tests to ensure functionality works as expected. To run the tests:

```bash
# Run all tests
vendor/bin/phpunit

# Run a specific test class
vendor/bin/phpunit tests/Endpoint/SubscriptionClientTest.php
```

### Writing Tests

If you're contributing to the library, please add tests for your changes. Tests are located in the `tests` directory, which mirrors the structure of the `src` directory.

Example of a test for an endpoint client:

```php
use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\YourClient;

class YourClientTest extends TestCase
{
    private $clientMock;
    private $yourClient;

    protected function setUp(): void
    {
        $this->clientMock = $this->createMock(Client::class);
        $this->yourClient = new YourClient($this->clientMock);
    }

    public function testYourMethod(): void
    {
        // Arrange
        $expectedResponse = ['key' => 'value'];

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with('your-endpoint')
            ->willReturn($expectedResponse);

        // Act
        $result = $this->yourClient->yourMethod();

        // Assert
        $this->assertSame($expectedResponse, $result);
    }
}
```

## License

This library is licensed under the AGPL-3.0-or-later license.
