<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Discounts;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Discount\DiscountMode;
use Paddle\SDK\Entities\Discount\DiscountStatus;
use Paddle\SDK\Entities\Discount\DiscountType;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Environment;
use Paddle\SDK\JsonEncoder;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Discounts\Operations\CreateDiscount;
use Paddle\SDK\Resources\Discounts\Operations\DiscountInclude;
use Paddle\SDK\Resources\Discounts\Operations\GetDiscount;
use Paddle\SDK\Resources\Discounts\Operations\ListDiscounts;
use Paddle\SDK\Resources\Discounts\Operations\UpdateDiscount;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DiscountsClientTest extends TestCase
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
        CreateDiscount $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->discounts->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/discounts', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateDiscount(
                '10',
                'Nonprofit discount',
                DiscountType::Percentage(),
                true,
                true,
                CurrencyCode::USD(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Create with Data' => [
            new CreateDiscount(
                amount: '10',
                description: 'Nonprofit discount',
                type: DiscountType::Percentage(),
                enabledForCheckout: true,
                recur: true,
                currencyCode: CurrencyCode::USD(),
                code: 'ABCDE12345',
                maximumRecurringIntervals: 5,
                usageLimit: 1000,
                restrictTo: ['pro_01gsz4t5hdjse780zja8vvr7jg', 'pro_01gsz4s0w61y0pp88528f1wvvb'],
                expiresAt: '2025-01-01 10:00:00',
                mode: DiscountMode::Standard(),
                discountGroupId: 'dsg_01gtf15svsqzgp9325ss4ebmwt',
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
        UpdateDiscount $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->discounts->update('dsc_01h83xenpcfjyhkqr4x214m02x', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/discounts/dsc_01h83xenpcfjyhkqr4x214m02x', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update Single' => [
            new UpdateDiscount(enabledForCheckout: false),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_single'),
        ];

        yield 'Update Partial' => [
            new UpdateDiscount(enabledForCheckout: false, code: null),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_partial'),
        ];

        yield 'Update All' => [
            new UpdateDiscount(
                amount: '10',
                description: 'Nonprofit discount',
                type: DiscountType::Percentage(),
                enabledForCheckout: true,
                recur: true,
                currencyCode: CurrencyCode::USD(),
                code: 'ABCDE12345',
                maximumRecurringIntervals: 5,
                usageLimit: 1000,
                restrictTo: [
                    'pro_01gsz4t5hdjse780zja8vvr7jg',
                    'pro_01gsz4s0w61y0pp88528f1wvvb',
                ],
                expiresAt: '2025-01-01 10:00:00',
                status: DiscountStatus::Active(),
                mode: DiscountMode::Custom(),
                discountGroupId: 'dsg_01gtf15svsqzgp9325ss4ebmwt',
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
        ListDiscounts $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $discounts = $this->client->discounts->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));

        self::assertJsonStringEqualsJsonString(
            json_encode(json_decode((string) $response->getBody(), true)['data'][0]),
            JsonEncoder::default()->encode($discounts->current()),
        );
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListDiscounts(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/discounts', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListDiscounts(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/discounts?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListDiscounts(new Pager(after: 'dsc_01h83xenpcfjyhkqr4x214m02x')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/discounts?after=dsc_01h83xenpcfjyhkqr4x214m02x&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'NotificationStatus Filtered' => [
            new ListDiscounts(statuses: [Status::Archived()]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/discounts?status=archived', Environment::SANDBOX->baseUrl()),
        ];

        yield 'ID Filtered' => [
            new ListDiscounts(ids: ['dsc_01h83xenpcfjyhkqr4x214m02x']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/discounts?id=dsc_01h83xenpcfjyhkqr4x214m02x', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple ID Filtered' => [
            new ListDiscounts(ids: ['dsc_01h83xenpcfjyhkqr4x214m02x', 'dsc_01gtgraak4chyhnp47rrdv89ad']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/discounts?id=dsc_01h83xenpcfjyhkqr4x214m02x,dsc_01gtgraak4chyhnp47rrdv89ad',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Code Filtered' => [
            new ListDiscounts(codes: ['ABCDE12345']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/discounts?code=ABCDE12345', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple Code Filtered' => [
            new ListDiscounts(codes: ['ABCDE12345', '54321EDCBA']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/discounts?code=ABCDE12345,54321EDCBA', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Discount Group ID Filtered' => [
            new ListDiscounts(discountGroupIds: ['dsg_01gtf15svsqzgp9325ss4ebmwt']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/discounts?discount_group_id=dsg_01gtf15svsqzgp9325ss4ebmwt', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple Discount Group ID Filtered' => [
            new ListDiscounts(discountGroupIds: ['dsg_01gtf15svsqzgp9325ss4ebmwt', 'dsg_02gtf15svsqzgp9325ss4ebmwt']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/discounts?discount_group_id=dsg_01gtf15svsqzgp9325ss4ebmwt,dsg_02gtf15svsqzgp9325ss4ebmwt',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Discount filtered by standard mode' => [
            new ListDiscounts(mode: DiscountMode::Standard()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/discounts?mode=standard',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Discount filtered by custom mode' => [
            new ListDiscounts(mode: DiscountMode::Custom()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/discounts?mode=custom',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Discount with discount group include' => [
            new ListDiscounts(includes: [DiscountInclude::DiscountGroup()]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/discounts?include=discount_group',
                Environment::SANDBOX->baseUrl(),
            ),
        ];
    }

    /** @test */
    public function get_hits_expected_uri(): void
    {
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity'));
        $this->mockClient->addResponse($response);
        $this->client->discounts->get('dsc_01h83xenpcfjyhkqr4x214m02x');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/discounts/dsc_01h83xenpcfjyhkqr4x214m02x', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
    }

    /** @test */
    public function get_hits_expected_uri_with_discount_group_included(): void
    {
        $responseBody = self::readRawJsonFixture('response/full_entity_include_discount_group');
        $response = new Response(200, body: $responseBody);
        $this->mockClient->addResponse($response);
        $discount = $this->client->discounts->get('dsc_01h83xenpcfjyhkqr4x214m02x', new GetDiscount(includes: [DiscountInclude::DiscountGroup()]));
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/discounts/dsc_01h83xenpcfjyhkqr4x214m02x?include=discount_group', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );

        self::assertJsonStringEqualsJsonString(
            json_encode(json_decode($responseBody, true)['data']),
            JsonEncoder::default()->encode($discount),
        );
    }

    /**
     * @test
     */
    public function it_uses_expected_payload_on_archive(): void
    {
        $this->mockClient->addResponse(
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
        );
        $this->client->discounts->archive('dsc_01h83xenpcfjyhkqr4x214m02x');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/discounts/dsc_01h83xenpcfjyhkqr4x214m02x', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString(
            self::readRawJsonFixture('request/archive'),
            (string) $request->getBody(),
        );
    }
}
