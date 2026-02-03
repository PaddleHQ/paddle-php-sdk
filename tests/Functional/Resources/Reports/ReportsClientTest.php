<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Reports;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Report\ReportFilter;
use Paddle\SDK\Entities\Report\ReportFilterName;
use Paddle\SDK\Entities\Report\ReportFilterOperator;
use Paddle\SDK\Entities\Report\ReportStatus;
use Paddle\SDK\Entities\Report\ReportType;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Reports\Operations\CreateReport;
use Paddle\SDK\Resources\Reports\Operations\ListReports;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ReportsClientTest extends TestCase
{
    use ReadsFixtures;

    private MockClient $mockClient;
    private Client $client;

    public function setUp(): void
    {
        $this->mockClient = new MockClient();
        $this->client = new Client(
            apiKey: 'API_KEY_PLACEHOLDER',
            options: new Options(Environment::SANDBOX),
            httpClient: $this->mockClient);
    }

    /**
     * @test
     *
     * @dataProvider createOperationsProvider
     */
    public function it_uses_expected_payload_on_create(
        CreateReport $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->reports->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/reports',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateReport(
                type: ReportType::Transactions(),
            ),
            new Response(201, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Create with filters' => [
            new CreateReport(
                type: ReportType::Transactions(),
                filters: [new ReportFilter(name: ReportFilterName::UpdatedAt(), operator: ReportFilterOperator::Lt(), value: '2023-12-30')],
            ),
            new Response(201, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_full'),
        ];

        yield 'Create payout reconciliation' => [
            new CreateReport(
                type: ReportType::PayoutReconciliation(),
            ),
            new Response(201, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_payout_reconciliation'),
        ];

        yield 'Create payout reconciliation with filters' => [
            new CreateReport(
                type: ReportType::PayoutReconciliation(),
                filters: [
                    new ReportFilter(name: ReportFilterName::UpdatedAt(), operator: ReportFilterOperator::Lt(), value: '2023-12-30'),
                ],
            ),
            new Response(201, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_payout_reconciliation_full'),
        ];

        yield 'Create payout reconciliation with remittance reference filter' => [
            new CreateReport(
                type: ReportType::PayoutReconciliation(),
                filters: [
                    new ReportFilter(
                        name: ReportFilterName::RemittanceReference(),
                        operator: null,
                        value: 'rem_01hhq4c3b03g3x2kpkj8aecjv6',
                    ),
                    new ReportFilter(
                        name: ReportFilterName::TransactionUpdatedAt(),
                        operator: ReportFilterOperator::Gte(),
                        value: '2023-12-30',
                    ),
                ],
            ),
            new Response(201, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_payout_reconciliation_with_filters'),
        ];

        yield 'Create balance report' => [
            new CreateReport(
                type: ReportType::Balance(),
            ),
            new Response(201, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_balance'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        ListReports $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->reports->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListReports(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/reports', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListReports(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/reports?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListReports(new Pager(after: 'rep_01hhq4c3b03g3x2kpkj8aecjv6')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/reports?after=rep_01hhq4c3b03g3x2kpkj8aecjv6&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Status Filtered' => [
            new ListReports(statuses: [ReportStatus::Ready()]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/reports?status=ready', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function get_hits_expected_uri(): void
    {
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity'));
        $this->mockClient->addResponse($response);
        $this->client->reports->get('rep_01hhq4c3b03g3x2kpkj8aecjv6');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/reports/rep_01hhq4c3b03g3x2kpkj8aecjv6', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
    }

    /** @test */
    public function get_report_csv_hits_expected_uri(): void
    {
        $response = new Response(200, body: self::readRawJsonFixture('response/report_csv_entity'));
        $this->mockClient->addResponse($response);
        $this->client->reports->getReportCsv('rep_01hhq4c3b03g3x2kpkj8aecjv6');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/reports/rep_01hhq4c3b03g3x2kpkj8aecjv6/download-url', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
    }
}
