<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\BlacklistClient;
use PHPUnit\Framework\TestCase;

class BlacklistClientTest extends TestCase
{
    private BlacklistClient $blacklistClient;

    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $client = new Client($baseUrl);
        // Blacklist endpoints require authentication header
        $client->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->blacklistClient = new BlacklistClient($client);
    }

    public function testCanCheckBlacklist(): void
    {
        $email = 'check_blacklist@example.com';
        $result = $this->blacklistClient->check($email);
        $this->assertIsArray($result);
        if (array_key_exists('blacklisted', $result)) {
            $this->assertIsBool($result['blacklisted']);
        }
        if (array_key_exists('reason', $result)) {
            $this->assertTrue(is_string($result['reason']) || $result['reason'] === null);
        }
    }

    public function testCanAddToBlacklist(): void
    {
        $email = 'add_blacklist_' . uniqid('', true) . '@example.com';
        $result = $this->blacklistClient->add($email, 'Unit test');
        $this->assertIsArray($result);
        if (array_key_exists('success', $result)) {
            $this->assertIsBool($result['success']);
        }
        if (array_key_exists('message', $result)) {
            $this->assertIsString($result['message']);
        }
    }

    public function testCanRemoveFromBlacklist(): void
    {
        $email = 'remove_blacklist_' . uniqid('', true) . '@example.com';
        // Ensure it exists first (ignore outcome details)
        $this->blacklistClient->add($email, 'Preparing for removal');

        $result = $this->blacklistClient->remove($email);
        $this->assertIsArray($result);
        if (array_key_exists('success', $result)) {
            $this->assertIsBool($result['success']);
        }
        if (array_key_exists('message', $result)) {
            $this->assertIsString($result['message']);
        }
    }

    public function testCanGetBlacklistInfo(): void
    {
        $email = 'info_blacklist_' . uniqid('', true) . '@example.com';
        // Ensure it exists to increase chance of info being returned
        $this->blacklistClient->add($email, 'Info check');

        $result = $this->blacklistClient->info($email);
        $this->assertIsArray($result);
        if (array_key_exists('email', $result)) {
            $this->assertIsString($result['email']);
        }
        if (array_key_exists('added', $result)) {
            $this->assertTrue(is_string($result['added']) || $result['added'] === null);
        }
        if (array_key_exists('reason', $result)) {
            $this->assertTrue(is_string($result['reason']) || $result['reason'] === null);
        }
    }
}
