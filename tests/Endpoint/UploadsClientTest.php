<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\UploadsClient;
use PHPUnit\Framework\TestCase;

class UploadsClientTest extends TestCase
{
    public function testGetUploadsCallsApi(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('editor-uploads', ['directory' => '/'])
            ->willReturn(['files' => [], 'directory' => '/', 'total' => 0]);

        $uploadsClient = new UploadsClient($mockClient);
        $result = $uploadsClient->getUploads();

        $this->assertSame(['files' => [], 'directory' => '/', 'total' => 0], $result);
    }

    public function testGetUploadedFileCallsApi(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('getRaw')
            ->with('editor-uploads/image.png', [], ['Accept' => 'application/octet-stream, */*;q=0.8'])
            ->willReturn('binary-content');

        $uploadsClient = new UploadsClient($mockClient);
        $result = $uploadsClient->getUploadedFile('image.png');

        $this->assertSame('binary-content', $result);
    }
}
