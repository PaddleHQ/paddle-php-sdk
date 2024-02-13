<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Addresses;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Shared\CountryCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Addresses\Operations\CreateAddress;
use Paddle\SDK\Resources\Addresses\Operations\ListAddresses;
use Paddle\SDK\Resources\Addresses\Operations\UpdateAddress;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AddressesClientTest extends TestCase
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
        CreateAddress $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->addresses->create('ctm_01h844p3h41s12zs5mn4axja51', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/customers/ctm_01h844p3h41s12zs5mn4axja51/addresses',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateAddress(CountryCode::AG()),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Create with Data' => [
            new CreateAddress(
                countryCode: CountryCode::US(),
                description: 'Head Office',
                firstLine: '4050 Jefferson Plaza, 41st Floor',
                secondLine: null,
                city: 'New York',
                postalCode: '10021',
                region: 'NY',
                customData: new CustomData(['shippable' => true]),
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
        UpdateAddress $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->addresses->update('ctm_01h844p3h41s12zs5mn4axja51', 'add_01h848pep46enq8y372x7maj0p', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/customers/ctm_01h844p3h41s12zs5mn4axja51/addresses/add_01h848pep46enq8y372x7maj0p',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update Single' => [
            new UpdateAddress(
                description: 'Head Office',
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_single'),
        ];

        yield 'Update Partial' => [
            new UpdateAddress(description: 'Head Office', city: 'New York'),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_partial'),
        ];

        yield 'Update All' => [
            new UpdateAddress(
                description: 'Head Office',
                firstLine: '4050 Jefferson Plaza, 41st Floor',
                secondLine: null,
                city: 'New York',
                postalCode: '10021',
                region: 'NY',
                countryCode: CountryCode::US(),
                customData: new CustomData(['shippable' => true]),
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
        ListAddresses $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->addresses->list('ctm_01h8441jn5pcwrfhwh78jqt8hk', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListAddresses(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/addresses', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListAddresses(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/addresses?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListAddresses(new Pager(after: 'add_01h848pep46enq8y372x7maj0p')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/addresses?after=add_01h848pep46enq8y372x7maj0p&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'NotificationStatus Filtered' => [
            new ListAddresses(statuses: [Status::Archived()]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/addresses?status=archived', Environment::SANDBOX->baseUrl()),
        ];

        yield 'ID Filtered' => [
            new ListAddresses(ids: ['add_01h848pep46enq8y372x7maj0p']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/addresses?id=add_01h848pep46enq8y372x7maj0p', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple ID Filtered' => [
            new ListAddresses(ids: ['add_01h8494f4w5rwfp8b12yqh8fp1', 'add_01h848pep46enq8y372x7maj0p']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/addresses?id=add_01h8494f4w5rwfp8b12yqh8fp1,add_01h848pep46enq8y372x7maj0p',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Search Filtered' => [
            new ListAddresses(search: 'Office'),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/addresses?search=Office', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function get_hits_expected_uri(): void
    {
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity'));
        $this->mockClient->addResponse($response);
        $this->client->addresses->get('ctm_01h844p3h41s12zs5mn4axja51', 'add_01h848pep46enq8y372x7maj0p');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/customers/ctm_01h844p3h41s12zs5mn4axja51/addresses/add_01h848pep46enq8y372x7maj0p', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
    }
}
