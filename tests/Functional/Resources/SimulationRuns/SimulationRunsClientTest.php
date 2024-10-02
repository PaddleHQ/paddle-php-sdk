<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\SimulationRuns;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Shared\Operations\List\OrderBy;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Resources\SimulationRuns\Operations\ListSimulationRuns;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SimulationRunsClientTest extends TestCase
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
     */
    public function it_uses_expected_payload_on_create(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/full_entity')));
        $this->client->simulationRuns->create('ntfsim_01j82g2mggsgjpb3mjg0xq6p5k');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString('{}', (string) $request->getBody());
    }

    /**
     * @test
     *
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        string $simulationId,
        ListSimulationRuns $listOperation,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_default')));
        $this->client->simulationRuns->list($simulationId, $listOperation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            new ListSimulationRuns(),
            sprintf('%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With ids filter' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            new ListSimulationRuns(ids: ['ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', 'ntfsimrun_01j82gjx7fxdc27bsqxf311cbe']),
            sprintf('%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs?id=ntfsim_01j82g2mggsgjpb3mjg0xq6p5k,ntfsimrun_01j82gjx7fxdc27bsqxf311cbe', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With default pagination' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            new ListSimulationRuns(
                new Pager(),
            ),
            sprintf('%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs?order_by=id[asc]&per_page=50', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With pagination after' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            new ListSimulationRuns(
                new Pager(after: 'ntfsimrun_01j82gvz2cgw08p7mak3gcd3a3'),
            ),
            sprintf(
                '%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs?after=ntfsimrun_01j82gvz2cgw08p7mak3gcd3a3&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID asc' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            new ListSimulationRuns(
                new Pager(after: 'ntfsimrun_01j82gvz2cgw08p7mak3gcd3a3', orderBy: OrderBy::idAscending()),
            ),
            sprintf(
                '%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs?after=ntfsimrun_01j82gvz2cgw08p7mak3gcd3a3&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID desc' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            new ListSimulationRuns(
                new Pager(after: 'ntfsimrun_01j82gvz2cgw08p7mak3gcd3a3', orderBy: OrderBy::idDescending()),
            ),
            sprintf(
                '%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs?after=ntfsimrun_01j82gvz2cgw08p7mak3gcd3a3&order_by=id[desc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID asc, per page' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            new ListSimulationRuns(
                new Pager(after: 'ntfsimrun_01j82gvz2cgw08p7mak3gcd3a3', orderBy: OrderBy::idDescending(), perPage: 10),
            ),
            sprintf(
                '%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs?after=ntfsimrun_01j82gvz2cgw08p7mak3gcd3a3&order_by=id[desc]&per_page=10',
                Environment::SANDBOX->baseUrl(),
            ),
        ];
    }

    /** @test */
    public function it_can_paginate(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_one')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_two')));

        $collection = $this->client->simulationRuns->list('ntfsim_01j82g2mggsgjpb3mjg0xq6p5k');

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs',
            urldecode((string) $request->getUri()),
        );

        $allSimulations = iterator_to_array($collection);
        self::assertCount(2, $allSimulations);

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs?after=ntfsimrun_01j82gvz2cgw08p7mak3gcd3a3',
            urldecode((string) $request->getUri()),
        );
    }

    /**
     * @test
     *
     * @dataProvider getRequestProvider
     */
    public function get_hits_expected_uri(
        string $simulationId,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->simulationRuns->get($simulationId, 'ntfsimrun_01j82h13n87yq2sfv187hm2r0p');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function getRequestProvider(): \Generator
    {
        yield 'Default' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            sprintf('%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p', Environment::SANDBOX->baseUrl()),
        ];
    }
}
