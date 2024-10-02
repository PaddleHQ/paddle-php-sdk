<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Simulations;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Shared\JSONObject;
use Paddle\SDK\Entities\Simulation\SimulationSingleEventType;
use Paddle\SDK\Entities\Simulation\SimulationStatus;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Shared\Operations\List\OrderBy;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Resources\Simulations\Operations\CreateSimulation;
use Paddle\SDK\Resources\Simulations\Operations\ListSimulations;
use Paddle\SDK\Resources\Simulations\Operations\UpdateSimulation;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SimulationsClientTest extends TestCase
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
        CreateSimulation $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->simulations->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/simulations', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateSimulation(
                notificationSettingId: 'ntfset_01j82d983j814ypzx7m1fw2jpz',
                type: SimulationSingleEventType::AddressCreated(),
                name: 'New US address created for CRM',
                payload: new JSONObject(json_decode(self::readRawJsonFixture('request/address_created_payload'), true),
                ),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider updateOperationsProvider
     */
    public function it_uses_expected_payload_on_update(
        UpdateSimulation $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->simulations->update('ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update Single' => [
            new UpdateSimulation(status: SimulationStatus::Archived()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_single'),
        ];

        yield 'Update Partial' => [
            new UpdateSimulation(
                notificationSettingId: 'ntfset_01j82d983j814ypzx7m1fw2jpz',
                name: 'New simulation name',
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_partial'),
        ];

        yield 'Update All' => [
            new UpdateSimulation(
                notificationSettingId: 'ntfset_01j82d983j814ypzx7m1fw2jpz',
                type: SimulationSingleEventType::AdjustmentUpdated(),
                name: 'Refund approved',
                status: SimulationStatus::Active(),
                payload: new JSONObject(json_decode(self::readRawJsonFixture('request/adjustment_updated_payload'), true),
                ),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_adjustment_updated')),
            self::readRawJsonFixture('request/update_full'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        ListSimulations $listOperation,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_default')));
        $this->client->simulations->list($listOperation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListSimulations(),
            sprintf('%s/simulations', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With status filter' => [
            new ListSimulations(statuses: [SimulationStatus::Active()]),
            sprintf('%s/simulations?status=active', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With default pagination' => [
            new ListSimulations(
                new Pager(),
            ),
            sprintf('%s/simulations?order_by=id[asc]&per_page=50', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With pagination after' => [
            new ListSimulations(
                new Pager('ntfsim_01j82d9tc19c67jds5vzbzjcns'),
            ),
            sprintf(
                '%s/simulations?after=ntfsim_01j82d9tc19c67jds5vzbzjcns&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID asc' => [
            new ListSimulations(
                new Pager('ntfsim_01j82d9tc19c67jds5vzbzjcns', OrderBy::idAscending()),
            ),
            sprintf(
                '%s/simulations?after=ntfsim_01j82d9tc19c67jds5vzbzjcns&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID desc' => [
            new ListSimulations(
                new Pager('ntfsim_01j82d9tc19c67jds5vzbzjcns', OrderBy::idDescending()),
            ),
            sprintf(
                '%s/simulations?after=ntfsim_01j82d9tc19c67jds5vzbzjcns&order_by=id[desc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID asc, per page' => [
            new ListSimulations(
                new Pager('ntfsim_01j82d9tc19c67jds5vzbzjcns', OrderBy::idDescending(), 10),
            ),
            sprintf(
                '%s/simulations?after=ntfsim_01j82d9tc19c67jds5vzbzjcns&order_by=id[desc]&per_page=10',
                Environment::SANDBOX->baseUrl(),
            ),
        ];
    }

    /** @test */
    public function it_can_paginate(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_one')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_two')));

        $collection = $this->client->simulations->list();

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/simulations',
            urldecode((string) $request->getUri()),
        );

        $allSimulations = iterator_to_array($collection);
        self::assertCount(2, $allSimulations);

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/simulations?after=ntfsim_01j82fs5pvrdse93e1kawqy2fr',
            urldecode((string) $request->getUri()),
        );
    }

    /**
     * @test
     *
     * @dataProvider getRequestProvider
     */
    public function get_hits_expected_uri(
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->simulations->get('ntfsim_01j82g2mggsgjpb3mjg0xq6p5k');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function getRequestProvider(): \Generator
    {
        yield 'Default' => [
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            sprintf('%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', Environment::SANDBOX->baseUrl()),
        ];
    }
}
