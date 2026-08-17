<?php

declare(strict_types=1);

namespace PhpList\RestApiClient\Tests\Endpoint;

use PHPUnit\Framework\TestCase;
use PhpList\RestApiClient\Client;
use PhpList\RestApiClient\Endpoint\StatisticsClient;
use PhpList\RestApiClient\Response\Statistics\CampaignPerformanceCollection;
use PhpList\RestApiClient\Response\Statistics\CampaignStatisticsCollection;
use PhpList\RestApiClient\Response\Statistics\DashboardSummaryResponse;
use PhpList\RestApiClient\Response\Statistics\RecentCampaignsCollection;
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

    public function testCanFetchDashboardSummary(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('analytics/dashboard/summary')
            ->willReturn([
                'total_subscribers' => ['value' => 100, 'change_vs_last_month' => 1.5],
                'active_campaigns' => ['value' => 2, 'change_vs_last_month' => 0],
                'open_rate' => ['value' => 12.3, 'change_vs_last_month' => -0.5],
                'bounce_rate' => ['value' => 0.2, 'change_vs_last_month' => 0.1],
            ]);

        $statisticsClient = new StatisticsClient($mockClient);
        $summary = $statisticsClient->getDashboardSummary();

        $this->assertInstanceOf(DashboardSummaryResponse::class, $summary);
        $this->assertSame(100, $summary->totalSubscribers->value);
    }

    public function testCanFetchRecentCampaigns(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('analytics/dashboard/recent-campaigns')
            ->willReturn([
                [
                    'name' => 'March Newsletter',
                    'status' => 'sent',
                    'date' => '2026-03-15',
                    'open_rate' => '42.50%',
                    'click_rate' => '8.10%',
                ],
            ]);

        $statisticsClient = new StatisticsClient($mockClient);
        $campaigns = $statisticsClient->getRecentCampaigns();

        $this->assertInstanceOf(RecentCampaignsCollection::class, $campaigns);
        $this->assertCount(1, $campaigns->campaigns);
        $this->assertSame('March Newsletter', $campaigns->campaigns[0]->name);
    }

    public function testCanFetchCampaignPerformance(): void
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('get')
            ->with('analytics/dashboard/performance')
            ->willReturn([
                [
                    'date' => '2026-03-19',
                    'opens' => 234,
                    'clicks' => 57,
                ],
            ]);

        $statisticsClient = new StatisticsClient($mockClient);
        $performance = $statisticsClient->getCampaignPerformance();

        $this->assertInstanceOf(CampaignPerformanceCollection::class, $performance);
        $this->assertCount(1, $performance->points);
        $this->assertSame(234, $performance->points[0]->opens);
        $this->assertSame(57, $performance->points[0]->clicks);
    }
}
