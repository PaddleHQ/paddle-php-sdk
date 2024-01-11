<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Businesses;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Shared\Contacts;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Businesses\Operations\CreateOperation;
use Paddle\SDK\Resources\Businesses\Operations\ListOperation;
use Paddle\SDK\Resources\Businesses\Operations\UpdateOperation;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class BusinessesClientTest extends TestCase
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
        CreateOperation $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->businesses->create('ctm_01h844p3h41s12zs5mn4axja51', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/customers/ctm_01h844p3h41s12zs5mn4axja51/businesses',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateOperation(
                name: 'ChatApp Inc.',
            ),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Create with Data' => [
            new CreateOperation(
                name: 'ChatApp Inc.',
                companyNumber: '555775291485',
                taxIdentifier: '555952383',
                contacts: [
                    new Contacts(
                        'Parker Jones',
                        'parker@example.com',
                    ),
                ],
                customData: new CustomData([
                    'customer_reference_id' => 'abcd1234',
                ]),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_full'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider updateOperationsProvider
     */
    public function it_uses_expected_payload_on_update(
        UpdateOperation $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->businesses->update('ctm_01h844p3h41s12zs5mn4axja51', 'biz_01h84a7hr4pzhsajkm8tev89ev', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/customers/ctm_01h844p3h41s12zs5mn4axja51/businesses/biz_01h84a7hr4pzhsajkm8tev89ev',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update Single' => [
            new UpdateOperation(name: 'ChatApp Inc.'),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_single'),
        ];

        yield 'Update Partial' => [
            new UpdateOperation(
                name: 'ChatApp Inc.',
                contacts: [
                    new Contacts('Parker Jones', 'parker@example.com'),
                    new Contacts('Jo Riley', 'jo@example.com'),
                    new Contacts('Jesse Garcia', 'jo@example.com'),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_partial'),
        ];

        yield 'Update All' => [
            new UpdateOperation(
                name: 'ChatApp Inc.',
                companyNumber: '555775291485',
                taxIdentifier: '555952383',
                contacts: [
                    new Contacts('Parker Jones', 'parker@example.com'),
                    new Contacts('Jo Riley', 'jo@example.com'),
                    new Contacts('Jesse Garcia', 'jo@example.com'),
                ],
                customData: new CustomData([
                    'customer_reference_id' => 'abcd1234',
                ]),
                status: Status::Active,
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_full'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        ListOperation $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->businesses->list('ctm_01h8441jn5pcwrfhwh78jqt8hk', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListOperation(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListOperation(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListOperation(new Pager(after: 'biz_01h84a7hr4pzhsajkm8tev89ev')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses?after=biz_01h84a7hr4pzhsajkm8tev89ev&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'NotificationStatus Filtered' => [
            new ListOperation(statuses: [Status::Archived]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses?status=archived', Environment::SANDBOX->baseUrl()),
        ];

        yield 'ID Filtered' => [
            new ListOperation(ids: ['biz_01h84a7hr4pzhsajkm8tev89ev']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses?id=biz_01h84a7hr4pzhsajkm8tev89ev', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple ID Filtered' => [
            new ListOperation(ids: ['biz_01h84a7hr4pzhsajkm8tev89ev', 'biz_01hf6pv0tmnw1cs0bcj2z8nmqx']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses?id=biz_01h84a7hr4pzhsajkm8tev89ev,biz_01hf6pv0tmnw1cs0bcj2z8nmqx',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Search Filtered' => [
            new ListOperation(search: 'ChatApp'),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses?search=ChatApp', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function get_hits_expected_uri(): void
    {
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity'));
        $this->mockClient->addResponse($response);
        $this->client->businesses->get('ctm_01h844p3h41s12zs5mn4axja51', 'biz_01h84a7hr4pzhsajkm8tev89ev');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/customers/ctm_01h844p3h41s12zs5mn4axja51/businesses/biz_01h84a7hr4pzhsajkm8tev89ev', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
    }
}
