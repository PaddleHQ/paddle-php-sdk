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
use Paddle\SDK\Resources\Businesses\Operations\CreateBusiness;
use Paddle\SDK\Resources\Businesses\Operations\ListBusinesses;
use Paddle\SDK\Resources\Businesses\Operations\UpdateBusiness;
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
        CreateBusiness $operation,
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
            new CreateBusiness(
                name: 'ChatApp Inc.',
            ),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Create with Data' => [
            new CreateBusiness(
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
        UpdateBusiness $operation,
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
            new UpdateBusiness(name: 'ChatApp Inc.'),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_single'),
        ];

        yield 'Update Partial' => [
            new UpdateBusiness(
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
            new UpdateBusiness(
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
                status: Status::Active(),
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
        ListBusinesses $operation,
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
            new ListBusinesses(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListBusinesses(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListBusinesses(new Pager(after: 'biz_01h84a7hr4pzhsajkm8tev89ev')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses?after=biz_01h84a7hr4pzhsajkm8tev89ev&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'NotificationStatus Filtered' => [
            new ListBusinesses(statuses: [Status::Archived()]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses?status=archived', Environment::SANDBOX->baseUrl()),
        ];

        yield 'ID Filtered' => [
            new ListBusinesses(ids: ['biz_01h84a7hr4pzhsajkm8tev89ev']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses?id=biz_01h84a7hr4pzhsajkm8tev89ev', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple ID Filtered' => [
            new ListBusinesses(ids: ['biz_01h84a7hr4pzhsajkm8tev89ev', 'biz_01hf6pv0tmnw1cs0bcj2z8nmqx']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/businesses?id=biz_01h84a7hr4pzhsajkm8tev89ev,biz_01hf6pv0tmnw1cs0bcj2z8nmqx',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Search Filtered' => [
            new ListBusinesses(search: 'ChatApp'),
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
