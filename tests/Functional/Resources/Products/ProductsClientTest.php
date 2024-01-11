<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Products;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Entities\Shared\TaxCategory;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Products\Operations\CreateProduct;
use Paddle\SDK\Resources\Products\Operations\List\Includes;
use Paddle\SDK\Resources\Products\Operations\ListProducts;
use Paddle\SDK\Resources\Products\Operations\UpdateProduct;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ProductsClientTest extends TestCase
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
        CreateProduct $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->products->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/products', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateProduct(
                name: 'ChatApp Basic',
                taxCategory: TaxCategory::Standard,
            ),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Create with Data' => [
            new CreateProduct(
                name: 'ChatApp Full',
                taxCategory: TaxCategory::Standard,
                description: 'Spend more time engaging with students with ChataApp Education.',
                imageUrl: 'https://paddle-sandbox.s3.amazonaws.com/user/10889/2nmP8MQSret0aWeDemRw_icon1.png',
                customData: new CustomData([
                    'features' => [
                        'reports' => true,
                        'crm' => false,
                        'data_retention' => true,
                    ],
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
        UpdateProduct $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->products->update('pro_01h7zcgmdc6tmwtjehp3sh7azf', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/products/pro_01h7zcgmdc6tmwtjehp3sh7azf', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update Single' => [
            new UpdateProduct(name: 'ChatApp Pro'),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_single'),
        ];

        yield 'Update Partial' => [
            new UpdateProduct(name: 'ChatApp Pro', taxCategory: TaxCategory::Saas),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_partial'),
        ];

        yield 'Update All' => [
            new UpdateProduct(
                name: 'ChatApp Pro',
                taxCategory: TaxCategory::Saas,
                description: 'Spend more time engaging with students with ChatApp Pro.',
                imageUrl: 'https://paddle-sandbox.s3.amazonaws.com/pro.png',
                customData: new CustomData([
                    'features' => [
                        'reports' => true,
                        'crm' => true,
                        'data_retention' => true,
                    ],
                ]),
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
        ListProducts $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->products->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListProducts(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/products', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListProducts(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/products?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListProducts(new Pager(after: 'pro_01gsz4s0w61y0pp88528f1wvvb')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/products?after=pro_01gsz4s0w61y0pp88528f1wvvb&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'NotificationStatus Filtered' => [
            new ListProducts(statuses: [Status::Archived]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/products?status=archived', Environment::SANDBOX->baseUrl()),
        ];

        yield 'ID Filtered' => [
            new ListProducts(ids: ['pro_01gsz4s0w61y0pp88528f1wvvb']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/products?id=pro_01gsz4s0w61y0pp88528f1wvvb', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple ID Filtered' => [
            new ListProducts(ids: ['pro_01gsz4s0w61y0pp88528f1wvvb', 'pro_01h1vjes1y163xfj1rh1tkfb65']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/products?id=pro_01gsz4s0w61y0pp88528f1wvvb,pro_01h1vjes1y163xfj1rh1tkfb65',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Tax Category Filtered' => [
            new ListProducts(taxCategories: [TaxCategory::DigitalGoods, TaxCategory::Standard]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/products?tax_category=digital-goods,standard', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With Includes' => [
            new ListProducts(includes: [Includes::Prices]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/products?include=prices', Environment::SANDBOX->baseUrl()),
        ];
    }

    /**
     * @test
     *
     * @dataProvider getRequestProvider
     *
     * @param Includes[] $includes
     */
    public function get_hits_expected_uri(
        array $includes,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->products->get('pro_01h7zcgmdc6tmwtjehp3sh7azf', $includes);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function getRequestProvider(): \Generator
    {
        yield 'Without Includes' => [
            [],
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            sprintf('%s/products/pro_01h7zcgmdc6tmwtjehp3sh7azf', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With Includes' => [
            [Includes::Prices],
            new Response(200, body: self::readRawJsonFixture('response/full_entity_with_includes')),
            sprintf('%s/products/pro_01h7zcgmdc6tmwtjehp3sh7azf?include=prices', Environment::SANDBOX->baseUrl()),
        ];
    }
}
