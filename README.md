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

You can initialize the client in two ways:

#### Method 1: Using the ClientFactory (Recommended)

```php
use PhpList\RestApiClient\ClientFactory;

// Create all clients at once
$clients = ClientFactory::createAllClients('https://your-phplist-api-url.com');

// Access individual clients
$client = $clients['client'];
$identityClient = $clients['identity'];
$authClient = $clients['identity'];
$campaignClient = $clients['campaign'];
$subscriptionClient = $clients['subscription'];
$statisticsClient = $clients['statistics'];

// Or create clients individually
$client = ClientFactory::createClient('https://your-phplist-api-url.com');
$authClient = ClientFactory::createIdentityClient($client);
```

#### Method 2: Manual Initialization

```php
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\CampaignClient;
use PhpList\RestApiClient\Endpoint\AuthClient;
use PhpList\RestApiClient\Endpoint\SubscriptionClient;
use PhpList\RestApiClient\Endpoint\StatisticsClient;

// Create the main client
$client = new Client('https://your-phplist-api-url.com');

// Create endpoint clients
$identityClient = new IdentityClient($client);
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
    $newCampaign = $campaignClient->createCampaign([
        'content' => [
            'subject' => 'New Campaign',
            'body' => '<p>Hello, world!</p>',
        ],
        'format' => [
            'html' => true,
            'text' => true,
        ],
        'metadata' => [
            'title' => 'My Campaign',
            'description' => 'A test campaign',
        ],
        'schedule' => [
            'send_at' => '2023-12-31 12:00:00',
        ],
        'options' => [
            'track_opens' => true,
            'track_clicks' => true,
        ],
    ]);

    // Update a campaign
    $updatedCampaign = $campaignClient->updateCampaign(123, [
        'content' => [
            'subject' => 'Updated Campaign',
        ],
    ]);

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

## License

This library is licensed under the AGPL-3.0-or-later license.
