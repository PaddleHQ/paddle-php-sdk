<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Transactions;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Shared\BillingDetails;
use Paddle\SDK\Entities\Shared\CollectionMode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Interval;
use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\PriceQuantity;
use Paddle\SDK\Entities\Shared\StatusTransaction;
use Paddle\SDK\Entities\Shared\TaxMode;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Transaction\TransactionCreateItem;
use Paddle\SDK\Entities\Transaction\TransactionCreateItemWithPrice;
use Paddle\SDK\Entities\Transaction\TransactionItemPreviewWithNonCatalogPrice;
use Paddle\SDK\Entities\Transaction\TransactionItemPreviewWithPriceId;
use Paddle\SDK\Entities\Transaction\TransactionNonCatalogPrice;
use Paddle\SDK\Entities\TransactionWithIncludes;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Shared\Operations\List\Comparator;
use Paddle\SDK\Resources\Shared\Operations\List\DateComparison;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Resources\Transactions\Operations\CreateTransaction;
use Paddle\SDK\Resources\Transactions\Operations\List\Includes;
use Paddle\SDK\Resources\Transactions\Operations\ListTransactions;
use Paddle\SDK\Resources\Transactions\Operations\PreviewTransaction;
use Paddle\SDK\Resources\Transactions\Operations\UpdateTransaction;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class TransactionsClientTest extends TestCase
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

    /** @test */
    public function it_can_paginate(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_one')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_two')));

        $collection = $this->client->transactions->list();

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/transactions',
            urldecode((string) $request->getUri()),
        );

        foreach ($collection as $transaction) {
            self::assertInstanceOf(TransactionWithIncludes::class, $transaction);
        }

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/transactions?after=txn_01h69ddtrb11km0wk46dn607ya',
            urldecode((string) $request->getUri()),
        );
    }

    /** @test */
    public function it_can_include_on_create(): void
    {
        $operation = new CreateTransaction(
            items: [
                new TransactionCreateItem('pri_01he5kxqey1k8ankgef29cj4bv', 1),
            ],
        );

        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/minimal_entity')));
        $this->client->transactions->create($operation, [Includes::Customer, Includes::Business]);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/transactions?include=customer,business',
            urldecode((string) $request->getUri()),
        );
    }

    /**
     * @test
     *
     * @dataProvider createOperationsProvider
     */
    public function it_uses_expected_payload_on_create(
        CreateTransaction $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->transactions->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/transactions', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateTransaction(
                items: [
                    new TransactionCreateItem('pri_01he5kxqey1k8ankgef29cj4bv', 1),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Create with non catalog price' => [
            new CreateTransaction(
                items: [
                    new TransactionCreateItemWithPrice(
                        new TransactionNonCatalogPrice(
                            'Annual (per seat)',
                            'Annual (per seat)',
                            new TimePeriod(Interval::Year, 1),
                            null,
                            TaxMode::AccountSetting,
                            new Money('30000', CurrencyCode::USD),
                            [],
                            new PriceQuantity(10, 999),
                            null,
                            'pro_01gsz4t5hdjse780zja8vvr7jg',
                        ),
                        20,
                    ),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_with_non_catalog_price'),
        ];

        yield 'Create Manually Collected' => [
            new CreateTransaction(
                items: [
                    new TransactionCreateItem('pri_01gsz8x8sawmvhz1pv30nge1ke', 1),
                ],
                status: StatusTransaction::Billed,
                customerId: 'ctm_01he849dseyj0zgrc589eeb1c7',
                addressId: 'add_01hen28ebw1ew99y295jhd4n3n',
                businessId: 'biz_01hen2ng2290g84twtefdn5s00',
                currencyCode: CurrencyCode::GBP,
                collectionMode: CollectionMode::Manual,
                discountId: 'dsc_01hen7bjzh12m0v2peer15d9qt',
                billingDetails: new BillingDetails(
                    enableCheckout: true,
                    paymentTerms: new TimePeriod(Interval::Month, 1),
                    purchaseOrderNumber: '10009',
                ),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_manual'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider updateOperationsProvider
     */
    public function it_uses_expected_payload_on_update(
        UpdateTransaction $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->transactions->update('txn_01h7zcgmdc6tmwtjehp3sh7azf', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/transactions/txn_01h7zcgmdc6tmwtjehp3sh7azf', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update Single' => [
            new UpdateTransaction(status: StatusTransaction::Billed),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_single'),
        ];

        yield 'Update Partial' => [
            new UpdateTransaction(
                status: StatusTransaction::Billed,
                customData: new CustomData(['completed_by' => 'Frank T']),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_partial'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        ListTransactions $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->transactions->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListTransactions(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListTransactions(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/transactions?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListTransactions(new Pager(after: 'txn_01hen7bxc1p8ep4yk7n5jbzk9r')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/transactions?after=txn_01hen7bxc1p8ep4yk7n5jbzk9r&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'NotificationStatus Filtered' => [
            new ListTransactions(statuses: [StatusTransaction::Billed]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?status=billed', Environment::SANDBOX->baseUrl()),
        ];

        yield 'NotificationStatus Filtered Multiple' => [
            new ListTransactions(statuses: [StatusTransaction::Billed, StatusTransaction::Completed]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?status=billed,completed', Environment::SANDBOX->baseUrl()),
        ];

        yield 'ID Filtered' => [
            new ListTransactions(ids: ['txn_01gsz4s0w61y0pp88528f1wvvb']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/transactions?id=txn_01gsz4s0w61y0pp88528f1wvvb',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Multiple ID Filtered' => [
            new ListTransactions(ids: ['txn_01gsz4s0w61y0pp88528f1wvvb', 'txn_01h1vjes1y163xfj1rh1tkfb65']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/transactions?id=txn_01gsz4s0w61y0pp88528f1wvvb,txn_01h1vjes1y163xfj1rh1tkfb65',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Collection Mode Filtered' => [
            new ListTransactions(collectionMode: CollectionMode::Automatic),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?collection_mode=automatic', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Billed At Filtered No Comparator' => [
            new ListTransactions(billedAt: new DateComparison(new \DateTimeImmutable('2023-11-06 14:00:00'))),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?billed_at=2023-11-06T14:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Billed At Filtered With Comparator' => [
            new ListTransactions(billedAt: new DateComparison(new \DateTimeImmutable('2023-11-06 14:00:00'), Comparator::GT)),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?billed_at[GT]=2023-11-06T14:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Invoice Number Filtered' => [
            new ListTransactions(invoiceNumbers: ['inv_01gsz4s0w61y0pp88528f1wvvb']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?invoice_number=inv_01gsz4s0w61y0pp88528f1wvvb', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Invoice Number Filtered multiple' => [
            new ListTransactions(invoiceNumbers: ['inv_01gsz4s0w61y0pp88528f1wvvb', 'inv_01h1vjes1y163xfj1rh1tkfb65']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?invoice_number=inv_01gsz4s0w61y0pp88528f1wvvb,inv_01h1vjes1y163xfj1rh1tkfb65', Environment::SANDBOX->baseUrl()),
        ];

        yield 'NotificationSubscription ID Filtered' => [
            new ListTransactions(subscriptionIds: ['sub_01gsz4s0w61y0pp88528f1wvvb']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?subscription_id=sub_01gsz4s0w61y0pp88528f1wvvb', Environment::SANDBOX->baseUrl()),
        ];

        yield 'NotificationSubscription ID Filtered Multiple' => [
            new ListTransactions(subscriptionIds: ['sub_01gsz4s0w61y0pp88528f1wvvb', 'sub_01h1vjes1y163xfj1rh1tkfb65']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?subscription_id=sub_01gsz4s0w61y0pp88528f1wvvb,sub_01h1vjes1y163xfj1rh1tkfb65', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Updated At Filtered No Comparator' => [
            new ListTransactions(updatedAt: new DateComparison(new \DateTimeImmutable('2023-11-06 14:00:00'))),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?updated_at=2023-11-06T14:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Updated At Filtered With Comparator' => [
            new ListTransactions(updatedAt: new DateComparison(new \DateTimeImmutable('2023-11-06 14:00:00'), Comparator::GT)),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?updated_at[GT]=2023-11-06T14:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Created At Filtered No Comparator' => [
            new ListTransactions(createdAt: new DateComparison(new \DateTimeImmutable('2023-11-06 14:00:00'))),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?created_at=2023-11-06T14:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Created At Filtered With Comparator' => [
            new ListTransactions(createdAt: new DateComparison(new \DateTimeImmutable('2023-11-06 14:00:00'), Comparator::GT)),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?created_at[GT]=2023-11-06T14:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With Includes' => [
            new ListTransactions(includes: [Includes::Customer]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?include=customer', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With Includes Multiple' => [
            new ListTransactions(includes: [Includes::Customer, Includes::Address, Includes::Discount]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/transactions?include=customer,address,discount', Environment::SANDBOX->baseUrl()),
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
        $this->client->transactions->get('txn_01hen7bxc1p8ep4yk7n5jbzk9r', $includes);
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
            sprintf('%s/transactions/txn_01hen7bxc1p8ep4yk7n5jbzk9r', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With Includes' => [
            [Includes::Customer, Includes::Address, Includes::Business, Includes::Discount],
            new Response(200, body: self::readRawJsonFixture('response/full_entity_with_includes')),
            sprintf('%s/transactions/txn_01hen7bxc1p8ep4yk7n5jbzk9r?include=customer,address,business,discount', Environment::SANDBOX->baseUrl()),
        ];
    }

    /**
     * @test
     *
     * @dataProvider previewOperationsProvider
     */
    public function it_uses_expected_payload_on_preview(
        PreviewTransaction $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->transactions->preview($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/transactions/preview', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function previewOperationsProvider(): \Generator
    {
        yield 'Basic Preview' => [
            new PreviewTransaction(
                items: [
                    new TransactionItemPreviewWithPriceId('pri_01he5kxqey1k8ankgef29cj4bv', 1, true),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_entity')),
            self::readRawJsonFixture('request/preview_basic'),
        ];

        yield 'Preview with non catalog price' => [
            new PreviewTransaction(
                items: [
                    new TransactionItemPreviewWithNonCatalogPrice(
                        new TransactionNonCatalogPrice(
                            'Annual (per seat)',
                            'Annual (per seat)',
                            new TimePeriod(Interval::Year, 1),
                            null,
                            TaxMode::AccountSetting,
                            new Money('30000', CurrencyCode::USD),
                            [],
                            new PriceQuantity(10, 999),
                            null,
                            'pro_01gsz4t5hdjse780zja8vvr7jg',
                        ),
                        20,
                        true,
                    ),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_entity')),
            self::readRawJsonFixture('request/preview_with_non_catalog_price'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider getInvoicePDFOperationsProvider
     */
    public function get_invoice_pdf_hits_expected_uri(
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->transactions->getInvoicePDF('txn_01hen7bxc1p8ep4yk7n5jbzk9r');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function getInvoicePDFOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new Response(200, body: self::readRawJsonFixture('response/get_invoice_pdf_default')),
            sprintf('%s/transactions/txn_01hen7bxc1p8ep4yk7n5jbzk9r/preview', Environment::SANDBOX->baseUrl()),
        ];
    }
}
