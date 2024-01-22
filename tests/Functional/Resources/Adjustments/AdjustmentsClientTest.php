<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Adjustments;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Adjustment\AdjustmentItem;
use Paddle\SDK\Entities\Adjustment\AdjustmentType;
use Paddle\SDK\Entities\Shared\Action;
use Paddle\SDK\Entities\Shared\StatusAdjustment;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Adjustments\Operations\CreateAdjustment;
use Paddle\SDK\Resources\Adjustments\Operations\ListAdjustments;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AdjustmentsClientTest extends TestCase
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
        CreateAdjustment $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->adjustments->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/adjustments',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateAdjustment(
                Action::Refund,
                [new AdjustmentItem(
                    'txnitm_01h8bxryv3065dyh6103p3yg28',
                    AdjustmentType::Partial,
                    '100',
                )],
                'error',
                'txn_01h8bxpvx398a7zbawb77y0kp5',
            ),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Create with Data' => [
            new CreateAdjustment(
                Action::Refund,
                [
                    new AdjustmentItem(
                        'txnitm_01h8bxryv3065dyh6103p3yg28',
                        AdjustmentType::Partial,
                        '100',
                    ),
                    new AdjustmentItem(
                        'txnitm_01h8bxryv3065dyh6103p3yg29',
                        AdjustmentType::Full,
                        '1949',
                    ),
                ],
                'error',
                'txn_01h8bxpvx398a7zbawb77y0kp5',
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_full'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        ListAdjustments $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->adjustments->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListAdjustments(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/adjustments', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListAdjustments(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/adjustments?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListAdjustments(new Pager(after: 'adj_01h8c65c2ggq5nxswnnwv78e75')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/adjustments?after=adj_01h8c65c2ggq5nxswnnwv78e75&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'NotificationStatus Filtered' => [
            new ListAdjustments(statuses: [StatusAdjustment::PendingApproval]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/adjustments?status=pending_approval', Environment::SANDBOX->baseUrl()),
        ];

        yield 'ID Filtered' => [
            new ListAdjustments(ids: ['adj_01h8c65c2ggq5nxswnnwv78e75']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/adjustments?id=adj_01h8c65c2ggq5nxswnnwv78e75', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple ID Filtered' => [
            new ListAdjustments(ids: ['add_01h8494f4w5rwfp8b12yqh8fp1', 'adj_01h8c65c2ggq5nxswnnwv78e75']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/adjustments?id=add_01h8494f4w5rwfp8b12yqh8fp1,adj_01h8c65c2ggq5nxswnnwv78e75',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Customer ID Filtered' => [
            new ListAdjustments(customerIds: ['ctm_01h8441jn5pcwrfhwh78jqt8hk']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/adjustments?customer_id=ctm_01h8441jn5pcwrfhwh78jqt8hk', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple Customer ID Filtered' => [
            new ListAdjustments(customerIds: ['ctm_01h8441jn5pcwrfhwh78jqt8hk', 'ctm_01h7hswb86rtps5ggbq7ybydcw']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/adjustments?customer_id=ctm_01h8441jn5pcwrfhwh78jqt8hk,ctm_01h7hswb86rtps5ggbq7ybydcw', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Transaction ID Filtered' => [
            new ListAdjustments(transactionIds: ['txn_01h8bxpvx398a7zbawb77y0kp5']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/adjustments?transaction_id=txn_01h8bxpvx398a7zbawb77y0kp5', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple Transaction ID Filtered' => [
            new ListAdjustments(transactionIds: ['ctm_01h8441jn5pcwrfhwh78jqt8hk', 'txn_01h8bx69629a16wwm9z8rjmak3']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/adjustments?transaction_id=ctm_01h8441jn5pcwrfhwh78jqt8hk,txn_01h8bx69629a16wwm9z8rjmak3', Environment::SANDBOX->baseUrl()),
        ];

        yield 'NotificationSubscription ID Filtered' => [
            new ListAdjustments(subscriptionIds: ['sub_01h8bxswamxysj44zt5n48njwh']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/adjustments?subscription_id=sub_01h8bxswamxysj44zt5n48njwh', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple NotificationSubscription ID Filtered' => [
            new ListAdjustments(subscriptionIds: ['sub_01h8bxswamxysj44zt5n48njwh', 'sub_01h8bx8fmywym11t6swgzba704']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/adjustments?subscription_id=sub_01h8bxswamxysj44zt5n48njwh,sub_01h8bx8fmywym11t6swgzba704', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Action Filtered' => [
            new ListAdjustments(action: Action::Refund),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/adjustments?action=refund', Environment::SANDBOX->baseUrl()),
        ];
    }
}
