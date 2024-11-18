<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Customers;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Customers\Operations\CreateCustomer;
use Paddle\SDK\Resources\Customers\Operations\ListCustomers;
use Paddle\SDK\Resources\Customers\Operations\UpdateCustomer;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CustomersClientTest extends TestCase
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
        CreateCustomer $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->customers->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/customers', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateCustomer('test2@example.com'),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Create with Data' => [
            new CreateCustomer(
                email: 'test2@example.com',
                name: 'Alex Wilson',
                customData: new CustomData(['customer_reference_id' => 'abcd1234']),
                locale: 'en',
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
        UpdateCustomer $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->customers->update('ctm_01h844p3h41s12zs5mn4axja51', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/customers/ctm_01h844p3h41s12zs5mn4axja51', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update Single' => [
            new UpdateCustomer(name: 'Alex Wilson'),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_single'),
        ];

        yield 'Update Partial' => [
            new UpdateCustomer(name: 'Alex Wilson', email: 'test1@example.com'),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_partial'),
        ];

        yield 'Update All' => [
            new UpdateCustomer(
                name: 'Alex Wilson',
                email: 'test1@example.com',
                locale: 'el',
                customData: new CustomData(['customer_reference_id' => 'abcd1234']),
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
        ListCustomers $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->customers->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListCustomers(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListCustomers(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListCustomers(new Pager(after: 'ctm_01h8441jn5pcwrfhwh78jqt8hk')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers?after=ctm_01h8441jn5pcwrfhwh78jqt8hk&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'NotificationStatus Filtered' => [
            new ListCustomers(statuses: [Status::Archived()]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers?status=archived', Environment::SANDBOX->baseUrl()),
        ];

        yield 'ID Filtered' => [
            new ListCustomers(ids: ['ctm_01h8441jn5pcwrfhwh78jqt8hk']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers?id=ctm_01h8441jn5pcwrfhwh78jqt8hk', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple ID Filtered' => [
            new ListCustomers(ids: ['ctm_01h8441jn5pcwrfhwh78jqt8hk', 'ctm_01h844p3h41s12zs5mn4axja51']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/customers?id=ctm_01h8441jn5pcwrfhwh78jqt8hk,ctm_01h844p3h41s12zs5mn4axja51',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Search Filtered' => [
            new ListCustomers(search: 'Alex'),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers?search=Alex', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Email Filtered' => [
            new ListCustomers(emails: ['dx@paddle.com']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/customers?email=dx@paddle.com', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function get_hits_expected_uri(): void
    {
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity'));
        $this->mockClient->addResponse($response);
        $this->client->customers->get('ctm_01h8441jn5pcwrfhwh78jqt8hk');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
    }

    /**
     * @test
     *
     * @dataProvider creditBalancesOperationsProvider
     */
    public function credit_balances_hits_expected_uri(
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->customers->creditBalances('ctm_01h8441jn5pcwrfhwh78jqt8hk');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function creditBalancesOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new Response(200, body: self::readRawJsonFixture('response/list_credit_balances')),
            sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/credit-balances', Environment::SANDBOX->baseUrl()),
        ];
    }

    /**
     * @test
     */
    public function create_auth_token_hits_expected_uri_and_parses_response(): void
    {
        $expectedUri = sprintf('%s/customers/ctm_01h8441jn5pcwrfhwh78jqt8hk/auth-token', Environment::SANDBOX->baseUrl());
        $response = new Response(200, body: self::readRawJsonFixture('response/auth_token'));

        $this->mockClient->addResponse($response);
        $authToken = $this->client->customers->generateAuthToken('ctm_01h8441jn5pcwrfhwh78jqt8hk');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertSame('', (string) $request->getBody());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));

        self::assertSame(
            'pca_01hwyzq8hmdwed5p4jc4hnv6bh_01hwwggymjn0yhhb2gr4p91276_6xaav4lydudt6bgmuefeaf2xnu3umegx',
            $authToken->customerAuthToken,
        );
        self::assertSame(
            '2024-05-03T10:34:12.345+00:00',
            $authToken->expiresAt->format(DATE_RFC3339_EXTENDED),
        );
    }
}
