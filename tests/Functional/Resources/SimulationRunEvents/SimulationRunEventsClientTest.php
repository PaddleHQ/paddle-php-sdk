<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\SimulationRunEvents;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Shared\Operations\List\OrderBy;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Resources\SimulationRunEvents\Operations\ListSimulationRunEvents;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SimulationRunEventsClientTest extends TestCase
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
    public function it_uses_expected_payload_on_replay(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/full_entity')));
        $this->client->simulationRunEvents->replay('ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', 'ntfsimrun_01j82h13n87yq2sfv187hm2r0p', 'ntfsimevt_01j82j3tr93j99gfv26tsngc27');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p/events/ntfsimevt_01j82j3tr93j99gfv26tsngc27/replay', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString('{}', (string) $request->getBody());
    }

    /**
     * @test
     *
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        string $simulationId,
        string $runId,
        ListSimulationRunEvents $listOperation,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_default')));
        $this->client->simulationRunEvents->list($simulationId, $runId, $listOperation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            'ntfsimrun_01j82h13n87yq2sfv187hm2r0p',
            new ListSimulationRunEvents(),
            sprintf('%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p/events', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With ids filter' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            'ntfsimrun_01j82h13n87yq2sfv187hm2r0p',
            new ListSimulationRunEvents(ids: ['ntfsimevt_01j82hf8jrwjsf9337a35tqghp', 'ntfsimevt_03j82hf8jrwjsf9337a35tqghx']),
            sprintf('%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p/events?id=ntfsimevt_01j82hf8jrwjsf9337a35tqghp,ntfsimevt_03j82hf8jrwjsf9337a35tqghx', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With default pagination' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            'ntfsimrun_01j82h13n87yq2sfv187hm2r0p',
            new ListSimulationRunEvents(
                new Pager(),
            ),
            sprintf('%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p/events?order_by=id[asc]&per_page=50', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With pagination after' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            'ntfsimrun_01j82h13n87yq2sfv187hm2r0p',
            new ListSimulationRunEvents(
                new Pager(after: 'ntfsimevt_01j82hf8jrwjsf9337a35tqghp'),
            ),
            sprintf(
                '%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p/events?after=ntfsimevt_01j82hf8jrwjsf9337a35tqghp&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID asc' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            'ntfsimrun_01j82h13n87yq2sfv187hm2r0p',
            new ListSimulationRunEvents(
                new Pager(after: 'ntfsimevt_01j82hf8jrwjsf9337a35tqghp', orderBy: OrderBy::idAscending()),
            ),
            sprintf(
                '%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p/events?after=ntfsimevt_01j82hf8jrwjsf9337a35tqghp&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID desc' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            'ntfsimrun_01j82h13n87yq2sfv187hm2r0p',
            new ListSimulationRunEvents(
                new Pager(after: 'ntfsimevt_01j82hf8jrwjsf9337a35tqghp', orderBy: OrderBy::idDescending()),
            ),
            sprintf(
                '%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p/events?after=ntfsimevt_01j82hf8jrwjsf9337a35tqghp&order_by=id[desc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID asc, per page' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            'ntfsimrun_01j82h13n87yq2sfv187hm2r0p',
            new ListSimulationRunEvents(
                new Pager(after: 'ntfsimevt_01j82hf8jrwjsf9337a35tqghp', orderBy: OrderBy::idDescending(), perPage: 10),
            ),
            sprintf(
                '%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p/events?after=ntfsimevt_01j82hf8jrwjsf9337a35tqghp&order_by=id[desc]&per_page=10',
                Environment::SANDBOX->baseUrl(),
            ),
        ];
    }

    /** @test */
    public function it_can_paginate(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_one')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_two')));

        $collection = $this->client->simulationRunEvents->list('ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', 'ntfsimrun_01j82h13n87yq2sfv187hm2r0p');

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p/events',
            urldecode((string) $request->getUri()),
        );

        $allSimulations = iterator_to_array($collection);
        self::assertCount(2, $allSimulations);

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p/events?after=ntfsimevt_01j82hf8jrwjsf9337a35tqghp',
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
        string $runId,
        string $id,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->simulationRunEvents->get($simulationId, $runId, $id);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function getRequestProvider(): \Generator
    {
        yield 'Default' => [
            'ntfsim_01j82g2mggsgjpb3mjg0xq6p5k',
            'ntfsimrun_01j82h13n87yq2sfv187hm2r0p',
            'ntfsimevt_01j82j3tr93j99gfv26tsngc27',
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            sprintf('%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k/runs/ntfsimrun_01j82h13n87yq2sfv187hm2r0p/events/ntfsimevt_01j82j3tr93j99gfv26tsngc27', Environment::SANDBOX->baseUrl()),
        ];
    }
}
