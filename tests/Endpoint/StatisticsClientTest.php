<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\StatisticsClient;
use PhpList\RestApiClient\Response\Statistics\CampaignStatisticsCollection;
use PhpList\RestApiClient\Response\Statistics\ViewOpensCollection;
use PhpList\RestApiClient\Response\Statistics\TopDomainsCollection;
use PhpList\RestApiClient\Entity\Statistics\DomainConfirmation;
use PhpList\RestApiClient\Entity\Statistics\TopLocalPart;
use PhpList\RestApiClient\Exception\AuthenticationException;

class StatisticsClientTest extends TestCase
{
    private StatisticsClient $statisticsClient;

    /**
     * @throws AuthenticationException
     */
    protected function setUp(): void
    {
        $baseUrl = getenv('API_BASE_URL') ?: null;
        $client = new Client($baseUrl);
        $client->login(getenv('API_USERNAME'), getenv('API_PASSWORD'));
        $this->statisticsClient = new StatisticsClient($client);
    }

    public function testCanFetchCampaignStatistics(): void
    {
        $statistics = $this->statisticsClient->getCampaignStatistics();
        $this->assertInstanceOf(CampaignStatisticsCollection::class, $statistics);
    }

    public function testCanFetchCampaignStatisticsWithPagination(): void
    {
        $statistics = $this->statisticsClient->getCampaignStatistics(null, 10);
        $this->assertInstanceOf(CampaignStatisticsCollection::class, $statistics);
        $this->assertLessThanOrEqual(10, count($statistics->items));
    }

    public function testCanFetchCampaignStatisticsWithAfterId(): void
    {
        $statistics = $this->statisticsClient->getCampaignStatistics(1, 10);
        $this->assertInstanceOf(CampaignStatisticsCollection::class, $statistics);
    }

    public function testCanFetchStatisticsOfViewOpens(): void
    {
        $statistics = $this->statisticsClient->getStatisticsOfViewOpens();
        $this->assertInstanceOf(ViewOpensCollection::class, $statistics);
    }

    public function testCanFetchStatisticsOfViewOpensWithPagination(): void
    {
        $statistics = $this->statisticsClient->getStatisticsOfViewOpens(null, 10);
        $this->assertInstanceOf(ViewOpensCollection::class, $statistics);
        $this->assertLessThanOrEqual(10, count($statistics->items));
    }

    public function testCanFetchStatisticsOfViewOpensWithAfterId(): void
    {
        $statistics = $this->statisticsClient->getStatisticsOfViewOpens(1, 10);
        $this->assertInstanceOf(ViewOpensCollection::class, $statistics);
    }

    public function testCanFetchTopDomains(): void
    {
        $statistics = $this->statisticsClient->getTopDomains();
        $this->assertInstanceOf(TopDomainsCollection::class, $statistics);
    }

    public function testCanFetchTopDomainsWithCustomParameters(): void
    {
        $statistics = $this->statisticsClient->getTopDomains(10, 2);
        $this->assertInstanceOf(TopDomainsCollection::class, $statistics);
    }

    public function testCanFetchDomainConfirmationStatistics(): void
    {
        $statistics = $this->statisticsClient->getDomainConfirmationStatistics();
        $this->assertInstanceOf(DomainConfirmation::class, $statistics);
    }

    public function testCanFetchDomainConfirmationStatisticsWithCustomLimit(): void
    {
        $statistics = $this->statisticsClient->getDomainConfirmationStatistics(20);
        $this->assertInstanceOf(DomainConfirmation::class, $statistics);
    }

    public function testCanFetchTopLocalParts(): void
    {
        $statistics = $this->statisticsClient->getTopLocalParts();
        $this->assertInstanceOf(TopLocalPart::class, $statistics);
    }

    public function testCanFetchTopLocalPartsWithCustomLimit(): void
    {
        $statistics = $this->statisticsClient->getTopLocalParts(10);
        $this->assertInstanceOf(TopLocalPart::class, $statistics);
    }
}
