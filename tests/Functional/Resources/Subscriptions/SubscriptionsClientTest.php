<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Subscriptions;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Shared\CatalogType;
use Paddle\SDK\Entities\Shared\CollectionMode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Interval;
use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\PriceQuantity;
use Paddle\SDK\Entities\Shared\TaxCategory;
use Paddle\SDK\Entities\Shared\TaxMode;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Subscription\SubscriptionEffectiveFrom;
use Paddle\SDK\Entities\Subscription\SubscriptionItems;
use Paddle\SDK\Entities\Subscription\SubscriptionItemsWithPrice;
use Paddle\SDK\Entities\Subscription\SubscriptionNonCatalogPrice;
use Paddle\SDK\Entities\Subscription\SubscriptionNonCatalogPriceWithProduct;
use Paddle\SDK\Entities\Subscription\SubscriptionNonCatalogProduct;
use Paddle\SDK\Entities\Subscription\SubscriptionOnPaymentFailure;
use Paddle\SDK\Entities\Subscription\SubscriptionOnResume;
use Paddle\SDK\Entities\Subscription\SubscriptionProrationBillingMode;
use Paddle\SDK\Entities\Subscription\SubscriptionResumeEffectiveFrom;
use Paddle\SDK\Entities\Subscription\SubscriptionScheduledChangeAction;
use Paddle\SDK\Entities\Subscription\SubscriptionStatus;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Resources\Subscriptions\Operations\CancelSubscription;
use Paddle\SDK\Resources\Subscriptions\Operations\CreateOneTimeCharge;
use Paddle\SDK\Resources\Subscriptions\Operations\Get\Includes;
use Paddle\SDK\Resources\Subscriptions\Operations\ListSubscriptions;
use Paddle\SDK\Resources\Subscriptions\Operations\PauseSubscription;
use Paddle\SDK\Resources\Subscriptions\Operations\PreviewOneTimeCharge;
use Paddle\SDK\Resources\Subscriptions\Operations\PreviewUpdateSubscription;
use Paddle\SDK\Resources\Subscriptions\Operations\ResumeSubscription;
use Paddle\SDK\Resources\Subscriptions\Operations\Update\SubscriptionDiscount;
use Paddle\SDK\Resources\Subscriptions\Operations\UpdateSubscription;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SubscriptionsClientTest extends TestCase
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
     * @dataProvider updateOperationsProvider
     */
    public function it_uses_expected_payload_on_update(
        UpdateSubscription $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->subscriptions->update('sub_01h8bx8fmywym11t6swgzba704', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/subscriptions/sub_01h8bx8fmywym11t6swgzba704',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update Single' => [
            new UpdateSubscription(prorationBillingMode: SubscriptionProrationBillingMode::ProratedNextBillingPeriod()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_single'),
        ];

        yield 'Update Partial' => [
            new UpdateSubscription(scheduledChange: null, prorationBillingMode: SubscriptionProrationBillingMode::FullImmediately()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_partial'),
        ];

        yield 'Update All' => [
            new UpdateSubscription(
                customerId: 'ctm_01h8441jn5pcwrfhwh78jqt8hk',
                addressId: 'add_01h848pep46enq8y372x7maj0p',
                businessId: null,
                currencyCode: CurrencyCode::GBP(),
                nextBilledAt: new \DateTimeImmutable('2023-11-06 14:00:00'),
                discount: new SubscriptionDiscount(
                    'dsc_01h848pep46enq8y372x7maj0p',
                    SubscriptionEffectiveFrom::NextBillingPeriod(),
                ),
                collectionMode: CollectionMode::Automatic(),
                billingDetails: null,
                scheduledChange: null,
                items: [
                    new SubscriptionItems('pri_01gsz91wy9k1yn7kx82aafwvea', 1),
                    new SubscriptionItems('pri_01gsz91wy9k1yn7kx82bafwvea', 5),
                    new SubscriptionItemsWithPrice(
                        new SubscriptionNonCatalogPrice(
                            'some description',
                            'some name',
                            'pro_01gsz4t5hdjse780zja8vvr7jg',
                            TaxMode::AccountSetting(),
                            new Money('1', CurrencyCode::GBP()),
                            [],
                            new PriceQuantity(1, 3),
                            new CustomData(['key' => 'value']),
                            new TimePeriod(Interval::Day(), 1),
                            new TimePeriod(Interval::Day(), 2),
                        ),
                        2,
                    ),
                    new SubscriptionItemsWithPrice(
                        new SubscriptionNonCatalogPriceWithProduct(
                            'some description',
                            'some name',
                            new SubscriptionNonCatalogProduct(
                                'some name',
                                'some description',
                                CatalogType::Custom(),
                                TaxCategory::DigitalGoods(),
                                'https://www.example.com/image.jpg',
                                new CustomData(['key' => 'value']),
                            ),
                            TaxMode::AccountSetting(),
                            new Money('1', CurrencyCode::GBP()),
                            [],
                            new PriceQuantity(1, 3),
                            new CustomData(['key' => 'value']),
                            new TimePeriod(Interval::Day(), 1),
                            new TimePeriod(Interval::Day(), 2),
                        ),
                        2,
                    ),
                ],
                customData: new CustomData(['early_access' => true]),
                prorationBillingMode: SubscriptionProrationBillingMode::FullImmediately(),
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
        ListSubscriptions $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->subscriptions->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListSubscriptions(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListSubscriptions(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/subscriptions?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListSubscriptions(new Pager(after: 'sub_01h848pep46enq8y372x7maj0p')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/subscriptions?after=sub_01h848pep46enq8y372x7maj0p&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'NotificationStatus Filtered' => [
            new ListSubscriptions(statuses: [SubscriptionStatus::Paused()]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?status=paused', Environment::SANDBOX->baseUrl()),
        ];

        yield 'ID Filtered' => [
            new ListSubscriptions(ids: ['sub_01h848pep46enq8y372x7maj0p']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?id=sub_01h848pep46enq8y372x7maj0p', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple ID Filtered' => [
            new ListSubscriptions(ids: ['sub_01h8494f4w5rwfp8b12yqh8fp1', 'sub_01h848pep46enq8y372x7maj0p']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/subscriptions?id=sub_01h8494f4w5rwfp8b12yqh8fp1,sub_01h848pep46enq8y372x7maj0p',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Collection Mode Filtered' => [
            new ListSubscriptions(collectionMode: CollectionMode::Automatic()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?collection_mode=automatic', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Address ID Filtered' => [
            new ListSubscriptions(addressIds: ['add_01h8494f4w5rwfp8b12yqh8fp1']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?address_id=add_01h8494f4w5rwfp8b12yqh8fp1', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple Address ID Filtered' => [
            new ListSubscriptions(addressIds: ['add_01h8494f4w5rwfp8b12yqh8fp1', 'add_01h848pep46enq8y372x7maj0p']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?address_id=add_01h8494f4w5rwfp8b12yqh8fp1,add_01h848pep46enq8y372x7maj0p', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Price ID Filtered' => [
            new ListSubscriptions(priceIds: ['pri_01h8494f4w5rwfp8b12yqh8fp1']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?price_id=pri_01h8494f4w5rwfp8b12yqh8fp1', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple Price ID Filtered' => [
            new ListSubscriptions(priceIds: ['pri_01h8494f4w5rwfp8b12yqh8fp1', 'pri_01h848pep46enq8y372x7maj0p']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?price_id=pri_01h8494f4w5rwfp8b12yqh8fp1,pri_01h848pep46enq8y372x7maj0p', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Scheduled Change Action Filtered' => [
            new ListSubscriptions(scheduledChangeActions: [SubscriptionScheduledChangeAction::Pause()]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?scheduled_change_action=pause', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple Scheduled Change Action Filtered' => [
            new ListSubscriptions(scheduledChangeActions: [
                SubscriptionScheduledChangeAction::Pause(),
                SubscriptionScheduledChangeAction::Cancel(),
            ]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?scheduled_change_action=pause,cancel', Environment::SANDBOX->baseUrl()),
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
        $this->client->subscriptions->get('sub_01h7zcgmdc6tmwtjehp3sh7azf', $includes);
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
            sprintf('%s/subscriptions/sub_01h7zcgmdc6tmwtjehp3sh7azf', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With Includes' => [
            [Includes::NextTransaction()],
            new Response(200, body: self::readRawJsonFixture('response/full_entity_with_includes')),
            sprintf('%s/subscriptions/sub_01h7zcgmdc6tmwtjehp3sh7azf?include=next_transaction', Environment::SANDBOX->baseUrl()),
        ];
    }

    /**
     * @test
     *
     * @dataProvider pauseOperationsProvider
     */
    public function pause_uses_expected_payload(
        PauseSubscription $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->subscriptions->pause('sub_01h8bx8fmywym11t6swgzba704', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/subscriptions/sub_01h8bx8fmywym11t6swgzba704/pause',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function pauseOperationsProvider(): \Generator
    {
        yield 'Update None' => [
            new PauseSubscription(),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/pause_none'),
        ];

        yield 'Update Single' => [
            new PauseSubscription(SubscriptionEffectiveFrom::NextBillingPeriod()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/pause_single'),
        ];

        yield 'Update All' => [
            new PauseSubscription(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                new \DateTime('2023-10-09T16:30:00Z'),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/pause_full'),
        ];

        yield 'On resume continue existing billing period' => [
            new PauseSubscription(SubscriptionEffectiveFrom::Immediately(), new \DateTime('2023-10-09T16:30:00Z'), SubscriptionOnResume::ContinueExistingBillingPeriod()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/pause_resume_existing_billing_period'),
        ];

        yield 'On resume start new billing period' => [
            new PauseSubscription(SubscriptionEffectiveFrom::Immediately(), new \DateTime('2023-10-09T16:30:00Z'), SubscriptionOnResume::StartNewBillingPeriod()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/pause_resume_new_billing_period'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider resumeOperationsProvider
     */
    public function resume_uses_expected_payload(
        ResumeSubscription $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->subscriptions->resume('sub_01h8bx8fmywym11t6swgzba704', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/subscriptions/sub_01h8bx8fmywym11t6swgzba704/resume',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function resumeOperationsProvider(): \Generator
    {
        yield 'Update None' => [
            new ResumeSubscription(),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/resume_none'),
        ];

        yield 'Update Single As Enum' => [
            new ResumeSubscription(SubscriptionResumeEffectiveFrom::Immediately()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/resume_single_as_enum'),
        ];

        yield 'Update Single As Date' => [
            new ResumeSubscription(new \DateTime('2023-10-09T16:30:00Z')),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/resume_single_as_date'),
        ];

        yield 'On resume continue existing billing period' => [
            new ResumeSubscription(SubscriptionResumeEffectiveFrom::Immediately(), SubscriptionOnResume::ContinueExistingBillingPeriod()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/resume_existing_billing_period'),
        ];

        yield 'On resume start new billing period' => [
            new ResumeSubscription(SubscriptionResumeEffectiveFrom::Immediately(), SubscriptionOnResume::StartNewBillingPeriod()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/resume_new_billing_period'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider cancelOperationsProvider
     */
    public function cancel_uses_expected_payload(
        CancelSubscription $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->subscriptions->cancel('sub_01h8bx8fmywym11t6swgzba704', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/subscriptions/sub_01h8bx8fmywym11t6swgzba704/cancel',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function cancelOperationsProvider(): \Generator
    {
        yield 'Update None' => [
            new CancelSubscription(),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/cancel_none'),
        ];

        yield 'Update Single' => [
            new CancelSubscription(SubscriptionEffectiveFrom::NextBillingPeriod()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/cancel_single'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider getPaymentMethodChangeTransactionRequestProvider
     */
    public function get_payment_method_change_transaction_hits_expected_uri(
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->subscriptions->getPaymentMethodChangeTransaction('sub_01h7zcgmdc6tmwtjehp3sh7azf');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function getPaymentMethodChangeTransactionRequestProvider(): \Generator
    {
        yield 'Basic' => [
            new Response(200, body: self::readRawJsonFixture('response/get_payment_method_change_transaction_entity')),
            sprintf('%s/subscriptions/sub_01h7zcgmdc6tmwtjehp3sh7azf/update-payment-method-transaction', Environment::SANDBOX->baseUrl()),
        ];
    }

    /**
     * @test
     *
     * @dataProvider activateOperationsProvider
     */
    public function activate_uses_expected_payload(
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->subscriptions->activate('sub_01h8bx8fmywym11t6swgzba704');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/subscriptions/sub_01h8bx8fmywym11t6swgzba704/activate',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function activateOperationsProvider(): \Generator
    {
        yield 'Update' => [
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            '{}',
        ];
    }

    /**
     * @test
     *
     * @dataProvider createOneTimeChargeOperationsProvider
     */
    public function create_one_time_charge_uses_expected_payload(
        CreateOneTimeCharge $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->subscriptions->createOneTimeCharge('sub_01h8bx8fmywym11t6swgzba704', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/subscriptions/sub_01h8bx8fmywym11t6swgzba704/charge',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOneTimeChargeOperationsProvider(): \Generator
    {
        yield 'Update Minimal' => [
            new CreateOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionItems('pri_01gsz98e27ak2tyhexptwc58yk', 1),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_one_time_charge_minimal'),
        ];

        yield 'Update Full' => [
            new CreateOneTimeCharge(
                SubscriptionEffectiveFrom::Immediately(),
                [
                    new SubscriptionItems('pri_01gsz98e27ak2tyhexptwc58yk', 1),
                    new SubscriptionItems('pri_01h7zdqstxe6djaefkqbkjy4k2', 10),
                    new SubscriptionItems('pri_01h7zd9mzfq79850w4ryc39v38', 845),
                ],
                SubscriptionOnPaymentFailure::ApplyChange(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_one_time_charge_full'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider previewUpdateOperationsProvider
     */
    public function it_uses_expected_payload_on_preview_update(
        PreviewUpdateSubscription $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->subscriptions->previewUpdate('sub_01h8bx8fmywym11t6swgzba704', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/subscriptions/sub_01h8bx8fmywym11t6swgzba704/preview',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function previewUpdateOperationsProvider(): \Generator
    {
        yield 'Preview Update Single' => [
            new PreviewUpdateSubscription(
                prorationBillingMode: SubscriptionProrationBillingMode::ProratedNextBillingPeriod(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_update_full_entity')),
            self::readRawJsonFixture('request/preview_update_single'),
        ];

        yield 'Preview Update Partial' => [
            new PreviewUpdateSubscription(
                scheduledChange: null,
                prorationBillingMode: SubscriptionProrationBillingMode::FullImmediately(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_update_full_entity')),
            self::readRawJsonFixture('request/preview_update_partial'),
        ];

        yield 'Preview Update All' => [
            new PreviewUpdateSubscription(
                customerId: 'ctm_01h8441jn5pcwrfhwh78jqt8hk',
                addressId: 'add_01h848pep46enq8y372x7maj0p',
                businessId: null,
                currencyCode: CurrencyCode::GBP(),
                nextBilledAt: new \DateTimeImmutable('2023-11-06 14:00:00'),
                discount: new SubscriptionDiscount(
                    'dsc_01h848pep46enq8y372x7maj0p',
                    SubscriptionEffectiveFrom::NextBillingPeriod(),
                ),
                collectionMode: CollectionMode::Automatic(),
                billingDetails: null,
                scheduledChange: null,
                items: [
                    new SubscriptionItems('pri_01gsz91wy9k1yn7kx82aafwvea', 1),
                    new SubscriptionItems('pri_01gsz91wy9k1yn7kx82bafwvea', 5),
                    new SubscriptionItemsWithPrice(
                        new SubscriptionNonCatalogPrice(
                            'some description',
                            'some name',
                            'pro_01gsz4t5hdjse780zja8vvr7jg',
                            TaxMode::AccountSetting(),
                            new Money('1', CurrencyCode::GBP()),
                            [],
                            new PriceQuantity(1, 3),
                            new CustomData(['key' => 'value']),
                            new TimePeriod(Interval::Day(), 1),
                            new TimePeriod(Interval::Day(), 2),
                        ),
                        2,
                    ),
                    new SubscriptionItemsWithPrice(
                        new SubscriptionNonCatalogPriceWithProduct(
                            'some description',
                            'some name',
                            new SubscriptionNonCatalogProduct(
                                'some name',
                                'some description',
                                CatalogType::Custom(),
                                TaxCategory::DigitalGoods(),
                                'https://www.example.com/image.jpg',
                                new CustomData(['key' => 'value']),
                            ),
                            TaxMode::AccountSetting(),
                            new Money('1', CurrencyCode::GBP()),
                            [],
                            new PriceQuantity(1, 3),
                            new CustomData(['key' => 'value']),
                            new TimePeriod(Interval::Day(), 1),
                            new TimePeriod(Interval::Day(), 2),
                        ),
                        2,
                    ),
                ],
                customData: new CustomData(['early_access' => true]),
                prorationBillingMode: SubscriptionProrationBillingMode::FullImmediately(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_update_full_entity')),
            self::readRawJsonFixture('request/preview_update_full'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider previewOneTimeChargeOperationsProvider
     */
    public function preview_one_time_charge_uses_expected_payload(
        PreviewOneTimeCharge $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->subscriptions->previewOneTimeCharge('sub_01h8bx8fmywym11t6swgzba704', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/subscriptions/sub_01h8bx8fmywym11t6swgzba704/charge/preview',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function previewOneTimeChargeOperationsProvider(): \Generator
    {
        yield 'Update Minimal' => [
            new PreviewOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionItems('pri_01gsz98e27ak2tyhexptwc58yk', 1),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_charge_full_entity')),
            self::readRawJsonFixture('request/preview_one_time_charge_minimal'),
        ];

        yield 'Update Full' => [
            new PreviewOneTimeCharge(
                SubscriptionEffectiveFrom::Immediately(),
                [
                    new SubscriptionItems('pri_01gsz98e27ak2tyhexptwc58yk', 1),
                    new SubscriptionItems('pri_01h7zdqstxe6djaefkqbkjy4k2', 10),
                    new SubscriptionItems('pri_01h7zd9mzfq79850w4ryc39v38', 845),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_charge_full_entity')),
            self::readRawJsonFixture('request/preview_one_time_charge_full'),
        ];
    }

    /**
     * @test
     */
    public function get_with_includes_returns_nullable_proration(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/full_entity_with_includes')));
        $subscription = $this->client->subscriptions->get('sub_01h8bx8fmywym11t6swgzba704');

        $recurringTransactionProration = $subscription->recurringTransactionDetails->lineItems[0]->proration;
        self::assertNotNull($recurringTransactionProration);
        self::assertEquals('1', $recurringTransactionProration->rate);
        self::assertEquals(
            '2024-02-08T11:02:03+00:00',
            $recurringTransactionProration->billingPeriod->startsAt->format(DATE_RFC3339),
        );
        self::assertEquals(
            '2024-03-08T11:02:03+00:00',
            $recurringTransactionProration->billingPeriod->endsAt->format(DATE_RFC3339),
        );

        $nullRecurringTransactionProration = $subscription->recurringTransactionDetails->lineItems[1]->proration;
        self::assertNull($nullRecurringTransactionProration);

        $nextTransactionProration = $subscription->nextTransaction->details->lineItems[0]->proration;
        self::assertNotNull($nextTransactionProration);
        self::assertEquals('1', $nextTransactionProration->rate);
        self::assertEquals(
            '2023-12-03T16:38:53+00:00',
            $nextTransactionProration->billingPeriod->startsAt->format(DATE_RFC3339),
        );
        self::assertEquals(
            '2024-01-03T16:38:53+00:00',
            $nextTransactionProration->billingPeriod->endsAt->format(DATE_RFC3339),
        );

        $nullNextTransactionProration = $subscription->nextTransaction->details->lineItems[1]->proration;
        self::assertNull($nullNextTransactionProration);
    }

    /**
     * @test
     */
    public function preview_returns_nullable_proration(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/preview_update_full_entity')));
        $subscriptionPreview = $this->client->subscriptions->previewUpdate(
            'sub_01h8bx8fmywym11t6swgzba704',
            new PreviewUpdateSubscription(
                prorationBillingMode: SubscriptionProrationBillingMode::ProratedNextBillingPeriod(),
            ),
        );

        $recurringTransactionProration = $subscriptionPreview->recurringTransactionDetails->lineItems[0]->proration;
        self::assertNotNull($recurringTransactionProration);
        self::assertEquals('1', $recurringTransactionProration->rate);
        self::assertEquals(
            '2024-02-08T11:02:03+00:00',
            $recurringTransactionProration->billingPeriod->startsAt->format(DATE_RFC3339),
        );
        self::assertEquals(
            '2024-03-08T11:02:03+00:00',
            $recurringTransactionProration->billingPeriod->endsAt->format(DATE_RFC3339),
        );

        $nullRecurringTransactionProration = $subscriptionPreview->recurringTransactionDetails->lineItems[1]->proration;
        self::assertNull($nullRecurringTransactionProration);

        $nextTransactionProration = $subscriptionPreview->nextTransaction->details->lineItems[0]->proration;
        self::assertNotNull($nextTransactionProration);
        self::assertEquals('1', $nextTransactionProration->rate);
        self::assertEquals(
            '2024-03-08T11:02:03+00:00',
            $nextTransactionProration->billingPeriod->startsAt->format(DATE_RFC3339),
        );
        self::assertEquals(
            '2024-04-08T11:02:03+00:00',
            $nextTransactionProration->billingPeriod->endsAt->format(DATE_RFC3339),
        );

        $nullNextTransactionProration = $subscriptionPreview->nextTransaction->details->lineItems[1]->proration;
        self::assertNull($nullNextTransactionProration);

        $immediateTransactionProration = $subscriptionPreview->immediateTransaction->details->lineItems[0]->proration;
        self::assertNotNull($immediateTransactionProration);
        self::assertEquals('0.99993', $immediateTransactionProration->rate);
        self::assertEquals(
            '2024-02-08T11:05:53+00:00',
            $immediateTransactionProration->billingPeriod->startsAt->format(DATE_RFC3339),
        );
        self::assertEquals(
            '2024-03-08T11:02:03+00:00',
            $immediateTransactionProration->billingPeriod->endsAt->format(DATE_RFC3339),
        );

        $nullImmediateTransactionProration = $subscriptionPreview->immediateTransaction->details->lineItems[1]->proration;
        self::assertNull($nullImmediateTransactionProration);
    }
}
