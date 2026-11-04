<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Subscriptions;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\SubscriptionHistoryCollection;
use Paddle\SDK\Entities\Shared\ActionSource;
use Paddle\SDK\Entities\Shared\ActorType;
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
use Paddle\SDK\Entities\Subscription\SubscriptionConsentRequirementStatus;
use Paddle\SDK\Entities\Subscription\SubscriptionConsentRequirementType;
use Paddle\SDK\Entities\Subscription\SubscriptionDiscountType;
use Paddle\SDK\Entities\Subscription\SubscriptionEffectiveFrom;
use Paddle\SDK\Entities\Subscription\SubscriptionItems;
use Paddle\SDK\Entities\Subscription\SubscriptionItemsWithPrice;
use Paddle\SDK\Entities\Subscription\SubscriptionNonCatalogPrice as EntitySubscriptionNonCatalogPrice;
use Paddle\SDK\Entities\Subscription\SubscriptionNonCatalogPriceWithProduct as EntitySubscriptionNonCatalogPriceWithProduct;
use Paddle\SDK\Entities\Subscription\SubscriptionNonCatalogProduct as EntitySubscriptionNonCatalogProduct;
use Paddle\SDK\Entities\Subscription\SubscriptionOnPaymentFailure;
use Paddle\SDK\Entities\Subscription\SubscriptionOnResume;
use Paddle\SDK\Entities\Subscription\SubscriptionProrationBillingMode;
use Paddle\SDK\Entities\Subscription\SubscriptionResumeEffectiveFrom;
use Paddle\SDK\Entities\Subscription\SubscriptionScheduledChangeAction;
use Paddle\SDK\Entities\Subscription\SubscriptionStatus;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryAction;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryCanceledEffectiveFrom;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionActivated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionAddressUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionBillingCycleUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionBillingDateUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionBillingDetailsUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionBusinessAdded;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionBusinessRemoved;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionBusinessUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionCanceled;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionCollectionModeUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionConsentRequirementGranted;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionCreated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionCurrencyUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionCustomDataUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionCustomerUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionDiscountAdded;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionDiscountExpired;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionDiscountRemoved;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionItemAdded;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionItemQuantityUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionItemRemoved;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionOneOffChargeApplied;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionPastDue;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionPaused;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionPaymentAttempted;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionPaymentMethodAdded;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionPaymentMethodRemoved;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionPaymentMethodUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionRenewed;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionResumed;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionScheduledChangeAdded;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionScheduledChangeRemoved;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailSubscriptionScheduledChangeUpdated;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDetailUndefined;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryDiscountType;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryReason;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Shared\Operations\List\Comparator;
use Paddle\SDK\Resources\Shared\Operations\List\DateComparison;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Resources\Subscriptions\Operations\CancelSubscription;
use Paddle\SDK\Resources\Subscriptions\Operations\Charge\SubscriptionChargeItem;
use Paddle\SDK\Resources\Subscriptions\Operations\Charge\SubscriptionChargeItemWithPrice;
use Paddle\SDK\Resources\Subscriptions\Operations\Charge\SubscriptionChargeNonCatalogPrice;
use Paddle\SDK\Resources\Subscriptions\Operations\Charge\SubscriptionChargeNonCatalogPriceWithProduct;
use Paddle\SDK\Resources\Subscriptions\Operations\Charge\SubscriptionChargeNonCatalogProduct;
use Paddle\SDK\Resources\Subscriptions\Operations\CreateOneTimeCharge;
use Paddle\SDK\Resources\Subscriptions\Operations\Get\Includes;
use Paddle\SDK\Resources\Subscriptions\Operations\ListSubscriptionHistory;
use Paddle\SDK\Resources\Subscriptions\Operations\ListSubscriptions;
use Paddle\SDK\Resources\Subscriptions\Operations\PauseSubscription;
use Paddle\SDK\Resources\Subscriptions\Operations\PreviewOneTimeCharge;
use Paddle\SDK\Resources\Subscriptions\Operations\PreviewUpdateSubscription;
use Paddle\SDK\Resources\Subscriptions\Operations\Price\SubscriptionNonCatalogPrice;
use Paddle\SDK\Resources\Subscriptions\Operations\Price\SubscriptionNonCatalogPriceWithProduct;
use Paddle\SDK\Resources\Subscriptions\Operations\Price\SubscriptionNonCatalogProduct;
use Paddle\SDK\Resources\Subscriptions\Operations\ResumeSubscription;
use Paddle\SDK\Resources\Subscriptions\Operations\Update\SubscriptionDiscount;
use Paddle\SDK\Resources\Subscriptions\Operations\Update\SubscriptionUpdateItem;
use Paddle\SDK\Resources\Subscriptions\Operations\Update\SubscriptionUpdateItemWithPrice;
use Paddle\SDK\Resources\Subscriptions\Operations\Update\UpdateBillingDetails;
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

        yield 'Update billing details' => [
            new UpdateSubscription(
                billingDetails: new UpdateBillingDetails(paymentTerms: new TimePeriod(Interval::Month(), 1)),
                prorationBillingMode: SubscriptionProrationBillingMode::ProratedNextBillingPeriod(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_billing_details'),
        ];

        yield 'Update Partial' => [
            new UpdateSubscription(scheduledChange: null, prorationBillingMode: SubscriptionProrationBillingMode::FullImmediately()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_partial'),
        ];

        yield 'Update Non-Catalog Product With Null Values' => [
            new UpdateSubscription(
                items: [
                    new SubscriptionUpdateItemWithPrice(
                        new SubscriptionNonCatalogPriceWithProduct(
                            description: 'some description',
                            unitPrice: new Money('1', CurrencyCode::GBP()),
                            product: new SubscriptionNonCatalogProduct(
                                name: 'some name',
                                taxCategory: TaxCategory::DigitalGoods(),
                                description: null,
                                imageUrl: null,
                                customData: null,
                            ),
                            name: 'some name',
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 3),
                            customData: null,
                        ),
                        2,
                    ),
                ],
                prorationBillingMode: SubscriptionProrationBillingMode::FullImmediately(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_non_catalog_product_with_nulls'),
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
                        new EntitySubscriptionNonCatalogPrice(
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
                        new EntitySubscriptionNonCatalogPriceWithProduct(
                            'some description',
                            'some name',
                            new EntitySubscriptionNonCatalogProduct(
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

        yield 'Update All (Operation Models)' => [
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
                    new SubscriptionUpdateItem('pri_01gsz91wy9k1yn7kx82aafwvea', 1),
                    new SubscriptionUpdateItem('pri_01gsz91wy9k1yn7kx82bafwvea', 5),
                    new SubscriptionUpdateItemWithPrice(
                        new SubscriptionNonCatalogPrice(
                            description: 'some description',
                            unitPrice: new Money('1', CurrencyCode::GBP()),
                            productId: 'pro_01gsz4t5hdjse780zja8vvr7jg',
                            name: 'some name',
                            billingCycle: new TimePeriod(Interval::Day(), 1),
                            trialPeriod: new TimePeriod(Interval::Day(), 2),
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 3),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        2,
                    ),
                    new SubscriptionUpdateItemWithPrice(
                        new SubscriptionNonCatalogPriceWithProduct(
                            description: 'some description',
                            unitPrice: new Money('1', CurrencyCode::GBP()),
                            product: new SubscriptionNonCatalogProduct(
                                'some name',
                                TaxCategory::DigitalGoods(),
                                'some description',
                                'https://www.example.com/image.jpg',
                                new CustomData(['key' => 'value']),
                            ),
                            name: 'some name',
                            billingCycle: new TimePeriod(Interval::Day(), 1),
                            trialPeriod: new TimePeriod(Interval::Day(), 2),
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 3),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        2,
                    ),
                ],
                customData: new CustomData(['early_access' => true]),
                prorationBillingMode: SubscriptionProrationBillingMode::FullImmediately(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_full_operation_models'),
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

        yield 'Next Billed At Filtered No Comparator' => [
            new ListSubscriptions(nextBilledAt: new DateComparison(new \DateTimeImmutable('2023-11-06 14:00:00'))),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?next_billed_at=2023-11-06T14:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Next Billed At Filtered With Comparator' => [
            new ListSubscriptions(nextBilledAt: new DateComparison(new \DateTimeImmutable('2023-11-06 14:00:00'), Comparator::LTE())),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?next_billed_at[LTE]=2023-11-06T14:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Next Billed At and Status Filtered' => [
            new ListSubscriptions(
                statuses: [SubscriptionStatus::Active()],
                nextBilledAt: new DateComparison(new \DateTimeImmutable('2023-11-06 14:00:00'), Comparator::GTE()),
            ),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/subscriptions?status=active&next_billed_at[GTE]=2023-11-06T14:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];
    }

    /**
     * @test
     */
    public function list_returns_discount_type(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_default')));
        $subscriptions = iterator_to_array($this->client->subscriptions->list(), false);

        $discountTypes = array_map(
            fn ($subscription) => $subscription->discount?->type,
            array_values(array_filter($subscriptions, fn ($subscription) => $subscription->discount !== null)),
        );

        self::assertEquals([SubscriptionDiscountType::Recurring(), SubscriptionDiscountType::OneOff()], $discountTypes);
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

        yield 'Charge With Receipt Data' => [
            new CreateOneTimeCharge(
                SubscriptionEffectiveFrom::Immediately(),
                [
                    new SubscriptionItems('pri_01gsz98e27ak2tyhexptwc58yk', 1),
                ],
                receiptData: 'PO number 12345',
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_one_time_charge_receipt_data'),
        ];

        yield 'Charge Catalog Item' => [
            new CreateOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionChargeItem('pri_01gsz98e27ak2tyhexptwc58yk', 1),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_one_time_charge_minimal'),
        ];

        yield 'Charge Non-Catalog Price (Operation Models)' => [
            new CreateOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionChargeItemWithPrice(
                        new SubscriptionChargeNonCatalogPrice(
                            description: 'One-time setup fee',
                            unitPrice: new Money('1000', CurrencyCode::USD()),
                            productId: 'pro_01gsz4t5hdjse780zja8vvr7jg',
                            name: 'Setup Fee',
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 1),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        1,
                    ),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_one_time_charge_non_catalog_price'),
        ];

        yield 'Charge Non-Catalog Price and Product (Operation Models)' => [
            new CreateOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionChargeItemWithPrice(
                        new SubscriptionChargeNonCatalogPriceWithProduct(
                            description: 'One-time setup fee',
                            unitPrice: new Money('1000', CurrencyCode::USD()),
                            product: new SubscriptionChargeNonCatalogProduct(
                                name: 'Custom Setup',
                                taxCategory: TaxCategory::DigitalGoods(),
                                description: 'One-time custom setup service',
                                imageUrl: 'https://www.example.com/image.jpg',
                                customData: new CustomData(['key' => 'value']),
                            ),
                            name: 'Setup Fee',
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 1),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        1,
                    ),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_one_time_charge_non_catalog_price_and_product'),
        ];

        yield 'Charge Non-Catalog Price' => [
            new CreateOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionChargeItemWithPrice(
                        new SubscriptionChargeNonCatalogPrice(
                            description: 'One-time setup fee',
                            unitPrice: new Money('1000', CurrencyCode::USD()),
                            productId: 'pro_01gsz4t5hdjse780zja8vvr7jg',
                            name: 'Setup Fee',
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 1),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        1,
                    ),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_one_time_charge_non_catalog_price'),
        ];

        yield 'Charge Non-Catalog Price and Product' => [
            new CreateOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionChargeItemWithPrice(
                        new SubscriptionChargeNonCatalogPriceWithProduct(
                            description: 'One-time setup fee',
                            unitPrice: new Money('1000', CurrencyCode::USD()),
                            product: new SubscriptionChargeNonCatalogProduct(
                                name: 'Custom Setup',
                                taxCategory: TaxCategory::DigitalGoods(),
                                description: 'One-time custom setup service',
                                imageUrl: 'https://www.example.com/image.jpg',
                                customData: new CustomData(['key' => 'value']),
                            ),
                            name: 'Setup Fee',
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 1),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        1,
                    ),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_one_time_charge_non_catalog_price_and_product'),
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
                        new EntitySubscriptionNonCatalogPrice(
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
                        new EntitySubscriptionNonCatalogPriceWithProduct(
                            'some description',
                            'some name',
                            new EntitySubscriptionNonCatalogProduct(
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

        yield 'Preview Update All (Operation Models)' => [
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
                    new SubscriptionUpdateItem('pri_01gsz91wy9k1yn7kx82aafwvea', 1),
                    new SubscriptionUpdateItem('pri_01gsz91wy9k1yn7kx82bafwvea', 5),
                    new SubscriptionUpdateItemWithPrice(
                        new SubscriptionNonCatalogPrice(
                            description: 'some description',
                            unitPrice: new Money('1', CurrencyCode::GBP()),
                            productId: 'pro_01gsz4t5hdjse780zja8vvr7jg',
                            name: 'some name',
                            billingCycle: new TimePeriod(Interval::Day(), 1),
                            trialPeriod: new TimePeriod(Interval::Day(), 2),
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 3),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        2,
                    ),
                    new SubscriptionUpdateItemWithPrice(
                        new SubscriptionNonCatalogPriceWithProduct(
                            description: 'some description',
                            unitPrice: new Money('1', CurrencyCode::GBP()),
                            product: new SubscriptionNonCatalogProduct(
                                'some name',
                                TaxCategory::DigitalGoods(),
                                'some description',
                                'https://www.example.com/image.jpg',
                                new CustomData(['key' => 'value']),
                            ),
                            name: 'some name',
                            billingCycle: new TimePeriod(Interval::Day(), 1),
                            trialPeriod: new TimePeriod(Interval::Day(), 2),
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 3),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        2,
                    ),
                ],
                customData: new CustomData(['early_access' => true]),
                prorationBillingMode: SubscriptionProrationBillingMode::FullImmediately(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_update_full_entity')),
            self::readRawJsonFixture('request/preview_update_full_operation_models'),
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

        yield 'Preview Charge Catalog Item' => [
            new PreviewOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionChargeItem('pri_01gsz98e27ak2tyhexptwc58yk', 1),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_charge_full_entity')),
            self::readRawJsonFixture('request/preview_one_time_charge_minimal'),
        ];

        yield 'Preview Charge Non-Catalog Price (Operation Models)' => [
            new PreviewOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionChargeItemWithPrice(
                        new SubscriptionChargeNonCatalogPrice(
                            description: 'One-time setup fee',
                            unitPrice: new Money('1000', CurrencyCode::USD()),
                            productId: 'pro_01gsz4t5hdjse780zja8vvr7jg',
                            name: 'Setup Fee',
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 1),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        1,
                    ),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_charge_full_entity')),
            self::readRawJsonFixture('request/preview_one_time_charge_non_catalog_price'),
        ];

        yield 'Preview Charge Non-Catalog Price and Product (Operation Models)' => [
            new PreviewOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionChargeItemWithPrice(
                        new SubscriptionChargeNonCatalogPriceWithProduct(
                            description: 'One-time setup fee',
                            unitPrice: new Money('1000', CurrencyCode::USD()),
                            product: new SubscriptionChargeNonCatalogProduct(
                                name: 'Custom Setup',
                                taxCategory: TaxCategory::DigitalGoods(),
                                description: 'One-time custom setup service',
                                imageUrl: 'https://www.example.com/image.jpg',
                                customData: new CustomData(['key' => 'value']),
                            ),
                            name: 'Setup Fee',
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 1),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        1,
                    ),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_charge_full_entity')),
            self::readRawJsonFixture('request/preview_one_time_charge_non_catalog_price_and_product'),
        ];

        yield 'Preview Charge Non-Catalog Price' => [
            new PreviewOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionChargeItemWithPrice(
                        new SubscriptionChargeNonCatalogPrice(
                            description: 'One-time setup fee',
                            unitPrice: new Money('1000', CurrencyCode::USD()),
                            productId: 'pro_01gsz4t5hdjse780zja8vvr7jg',
                            name: 'Setup Fee',
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 1),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        1,
                    ),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_charge_full_entity')),
            self::readRawJsonFixture('request/preview_one_time_charge_non_catalog_price'),
        ];

        yield 'Preview Charge Non-Catalog Price and Product' => [
            new PreviewOneTimeCharge(
                SubscriptionEffectiveFrom::NextBillingPeriod(),
                [
                    new SubscriptionChargeItemWithPrice(
                        new SubscriptionChargeNonCatalogPriceWithProduct(
                            description: 'One-time setup fee',
                            unitPrice: new Money('1000', CurrencyCode::USD()),
                            product: new SubscriptionChargeNonCatalogProduct(
                                name: 'Custom Setup',
                                taxCategory: TaxCategory::DigitalGoods(),
                                description: 'One-time custom setup service',
                                imageUrl: 'https://www.example.com/image.jpg',
                                customData: new CustomData(['key' => 'value']),
                            ),
                            name: 'Setup Fee',
                            taxMode: TaxMode::AccountSetting(),
                            unitPriceOverrides: [],
                            quantity: new PriceQuantity(1, 1),
                            customData: new CustomData(['key' => 'value']),
                        ),
                        1,
                    ),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/preview_charge_full_entity')),
            self::readRawJsonFixture('request/preview_one_time_charge_non_catalog_price_and_product'),
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

    /**
     * @test
     */
    public function preview_returns_consent_requirements(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/preview_update_full_entity')));
        $subscriptionPreview = $this->client->subscriptions->previewUpdate(
            'sub_01h8bx8fmywym11t6swgzba704',
            new PreviewUpdateSubscription(
                prorationBillingMode: SubscriptionProrationBillingMode::ProratedNextBillingPeriod(),
            ),
        );

        self::assertCount(1, $subscriptionPreview->consentRequirements);

        $consentRequirement = $subscriptionPreview->consentRequirements[0];
        self::assertSame('subconreq_01hp463gxfvndqjjyqn2n7tkth', $consentRequirement->id);
        self::assertEquals(SubscriptionConsentRequirementType::TrialEnding(), $consentRequirement->requirement);
        self::assertEquals(SubscriptionConsentRequirementStatus::Pending(), $consentRequirement->status);
        self::assertSame('2024-02-08T11:02:03+00:00', $consentRequirement->consentPeriod->startsAt->format(DATE_RFC3339));
        self::assertSame('2024-03-08T11:02:03+00:00', $consentRequirement->consentPeriod->endsAt->format(DATE_RFC3339));
        self::assertNull($consentRequirement->grantedAt);
        self::assertNull($consentRequirement->voidedAt);
    }

    /**
     * @test
     *
     * @dataProvider listHistoryOperationsProvider
     */
    public function list_history_hits_expected_uri(
        ListSubscriptionHistory $operation,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_history_default')));
        $collection = $this->client->subscriptions->listHistory('sub_01hv959anj4zrw503h2acawb3p', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(SubscriptionHistoryCollection::class, $collection);
        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listHistoryOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListSubscriptionHistory(),
            sprintf('%s/subscriptions/sub_01hv959anj4zrw503h2acawb3p/history', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListSubscriptionHistory(new Pager()),
            sprintf('%s/subscriptions/sub_01hv959anj4zrw503h2acawb3p/history?order_by=id[asc]&per_page=50', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Filtered' => [
            new ListSubscriptionHistory(
                actions: [SubscriptionHistoryAction::SubscriptionRenewed(), SubscriptionHistoryAction::SubscriptionPaused()],
                sources: [ActionSource::Api(), ActionSource::Dashboard()],
                actorTypes: [ActorType::ApiKey()],
                actorIds: ['apikey_01h8441jn5pcwrfhwh78jqt8hl'],
                reasons: [SubscriptionHistoryReason::CustomerRequest()],
                occurredAt: new DateComparison(new \DateTime('2026-06-01 00:00:00'), Comparator::GTE()),
            ),
            sprintf(
                '%s/subscriptions/sub_01hv959anj4zrw503h2acawb3p/history'
                . '?action=subscription_renewed,subscription_paused'
                . '&source=api,dashboard'
                . '&actor_type=api_key'
                . '&actor_id=apikey_01h8441jn5pcwrfhwh78jqt8hl'
                . '&reason=customer_request'
                . '&occurred_at[GTE]=2026-06-01T00:00:00.000000Z',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Occurred At Without Comparator' => [
            new ListSubscriptionHistory(occurredAt: new DateComparison(new \DateTime('2026-06-01 00:00:00'))),
            sprintf('%s/subscriptions/sub_01hv959anj4zrw503h2acawb3p/history?occurred_at=2026-06-01T00:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function list_history_returns_expected_entities(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_history_default')));
        $entries = iterator_to_array($this->client->subscriptions->listHistory('sub_01hv959anj4zrw503h2acawb3p'), false);

        self::assertCount(11, $entries);

        $created = $entries[0];
        self::assertSame('subhis_01k0w0a4m6v7w8x9y0z1a2b3c4', $created->id);
        self::assertSame('sub_01hv959anj4zrw503h2acawb3p', $created->subscriptionId);
        self::assertEquals(ActionSource::Checkout(), $created->source);
        self::assertEquals(ActorType::Customer(), $created->actor->type);
        self::assertSame('ctm_01hv8wt8nffez4p2t6typn4a5j', $created->actor->id);
        self::assertNull($created->reason);
        self::assertInstanceOf(SubscriptionHistoryDetailSubscriptionCreated::class, $created->detail);
        self::assertEquals(SubscriptionStatus::Active(), $created->detail->status);
        self::assertEquals(CollectionMode::Automatic(), $created->detail->collectionMode);
        self::assertNull($created->detail->billingDetails);
        self::assertNull($created->detail->customer);
        self::assertEquals(CurrencyCode::USD(), $created->detail->currencyCode);

        $activated = $entries[1];
        self::assertEquals(ActorType::System(), $activated->actor->type);
        self::assertNull($activated->actor->id);
        self::assertInstanceOf(SubscriptionHistoryDetailSubscriptionActivated::class, $activated->detail);
        self::assertEquals(SubscriptionHistoryAction::SubscriptionActivated(), $activated->detail->action);
        self::assertSame('txn_01h89231k3a1q8mn6p4r5s7t9v', $activated->detail->transactionId);
        self::assertSame('2026-06-29T12:42:28.000000Z', $activated->detail->firstBilledAt?->format('Y-m-d\TH:i:s.u\Z'));

        $itemAdded = $entries[3];
        self::assertInstanceOf(SubscriptionHistoryDetailSubscriptionItemAdded::class, $itemAdded->detail);
        self::assertSame('pri_01gsz8x8sawmvhz1pv30nge1ke', $itemAdded->detail->price->id);

        $discountAdded = $entries[4];
        self::assertInstanceOf(SubscriptionHistoryDetailSubscriptionDiscountAdded::class, $discountAdded->detail);
        self::assertSame('dsc_01h83xenpcfjyhkqr4x214m02x', $discountAdded->detail->discount->discount->id);
        self::assertInstanceOf(SubscriptionHistoryDiscountType::class, $discountAdded->detail->discount->type);

        $canceled = $entries[6];
        self::assertEquals(SubscriptionHistoryReason::CustomerRequest(), $canceled->reason);
        self::assertInstanceOf(SubscriptionHistoryDetailSubscriptionCanceled::class, $canceled->detail);
        self::assertEquals(SubscriptionHistoryCanceledEffectiveFrom::NextBillingPeriod(), $canceled->detail->effectiveFrom);
    }

    /** @test */
    public function list_history_hydrates_unknown_action_as_undefined_detail(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_history_default')));
        $entries = iterator_to_array($this->client->subscriptions->listHistory('sub_01hv959anj4zrw503h2acawb3p'), false);

        $unknown = end($entries);
        self::assertEquals(ActionSource::Unknown(), $unknown->source);
        self::assertInstanceOf(SubscriptionHistoryDetailUndefined::class, $unknown->detail);
        self::assertFalse($unknown->detail->action->isKnown());
        self::assertSame('subscription_something_new', $unknown->detail->action->getValue());
        self::assertSame(['action' => 'subscription_something_new', 'some_field' => 'some_value'], $unknown->detail->data);
    }

    /**
     * @test
     *
     * @dataProvider historyDetailTypesProvider
     *
     * @param class-string $expectedClass
     */
    public function list_history_hydrates_action_as_typed_detail(string $action, string $expectedClass): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_history_all_actions')));
        $entries = iterator_to_array($this->client->subscriptions->listHistory('sub_01hv959anj4zrw503h2acawb3p'), false);

        $matching = array_values(array_filter(
            $entries,
            fn ($entry): bool => $entry->detail->action->getValue() === $action,
        ));

        self::assertCount(1, $matching, "Fixture list_history_all_actions is missing an entry for {$action}");
        self::assertInstanceOf($expectedClass, $matching[0]->detail);
        self::assertTrue($matching[0]->detail->action->isKnown());
    }

    public static function historyDetailTypesProvider(): \Generator
    {
        yield 'subscription_activated' => ['subscription_activated', SubscriptionHistoryDetailSubscriptionActivated::class];
        yield 'subscription_address_updated' => ['subscription_address_updated', SubscriptionHistoryDetailSubscriptionAddressUpdated::class];
        yield 'subscription_billing_cycle_updated' => ['subscription_billing_cycle_updated', SubscriptionHistoryDetailSubscriptionBillingCycleUpdated::class];
        yield 'subscription_billing_date_updated' => ['subscription_billing_date_updated', SubscriptionHistoryDetailSubscriptionBillingDateUpdated::class];
        yield 'subscription_billing_details_updated' => ['subscription_billing_details_updated', SubscriptionHistoryDetailSubscriptionBillingDetailsUpdated::class];
        yield 'subscription_business_added' => ['subscription_business_added', SubscriptionHistoryDetailSubscriptionBusinessAdded::class];
        yield 'subscription_business_removed' => ['subscription_business_removed', SubscriptionHistoryDetailSubscriptionBusinessRemoved::class];
        yield 'subscription_business_updated' => ['subscription_business_updated', SubscriptionHistoryDetailSubscriptionBusinessUpdated::class];
        yield 'subscription_canceled' => ['subscription_canceled', SubscriptionHistoryDetailSubscriptionCanceled::class];
        yield 'subscription_collection_mode_updated' => ['subscription_collection_mode_updated', SubscriptionHistoryDetailSubscriptionCollectionModeUpdated::class];
        yield 'subscription_consent_requirement_granted' => ['subscription_consent_requirement_granted', SubscriptionHistoryDetailSubscriptionConsentRequirementGranted::class];
        yield 'subscription_created' => ['subscription_created', SubscriptionHistoryDetailSubscriptionCreated::class];
        yield 'subscription_currency_updated' => ['subscription_currency_updated', SubscriptionHistoryDetailSubscriptionCurrencyUpdated::class];
        yield 'subscription_custom_data_updated' => ['subscription_custom_data_updated', SubscriptionHistoryDetailSubscriptionCustomDataUpdated::class];
        yield 'subscription_customer_updated' => ['subscription_customer_updated', SubscriptionHistoryDetailSubscriptionCustomerUpdated::class];
        yield 'subscription_discount_added' => ['subscription_discount_added', SubscriptionHistoryDetailSubscriptionDiscountAdded::class];
        yield 'subscription_discount_expired' => ['subscription_discount_expired', SubscriptionHistoryDetailSubscriptionDiscountExpired::class];
        yield 'subscription_discount_removed' => ['subscription_discount_removed', SubscriptionHistoryDetailSubscriptionDiscountRemoved::class];
        yield 'subscription_item_added' => ['subscription_item_added', SubscriptionHistoryDetailSubscriptionItemAdded::class];
        yield 'subscription_item_quantity_updated' => ['subscription_item_quantity_updated', SubscriptionHistoryDetailSubscriptionItemQuantityUpdated::class];
        yield 'subscription_item_removed' => ['subscription_item_removed', SubscriptionHistoryDetailSubscriptionItemRemoved::class];
        yield 'subscription_one_off_charge_applied' => ['subscription_one_off_charge_applied', SubscriptionHistoryDetailSubscriptionOneOffChargeApplied::class];
        yield 'subscription_past_due' => ['subscription_past_due', SubscriptionHistoryDetailSubscriptionPastDue::class];
        yield 'subscription_paused' => ['subscription_paused', SubscriptionHistoryDetailSubscriptionPaused::class];
        yield 'subscription_payment_attempted' => ['subscription_payment_attempted', SubscriptionHistoryDetailSubscriptionPaymentAttempted::class];
        yield 'subscription_payment_method_added' => ['subscription_payment_method_added', SubscriptionHistoryDetailSubscriptionPaymentMethodAdded::class];
        yield 'subscription_payment_method_removed' => ['subscription_payment_method_removed', SubscriptionHistoryDetailSubscriptionPaymentMethodRemoved::class];
        yield 'subscription_payment_method_updated' => ['subscription_payment_method_updated', SubscriptionHistoryDetailSubscriptionPaymentMethodUpdated::class];
        yield 'subscription_renewed' => ['subscription_renewed', SubscriptionHistoryDetailSubscriptionRenewed::class];
        yield 'subscription_resumed' => ['subscription_resumed', SubscriptionHistoryDetailSubscriptionResumed::class];
        yield 'subscription_scheduled_change_added' => ['subscription_scheduled_change_added', SubscriptionHistoryDetailSubscriptionScheduledChangeAdded::class];
        yield 'subscription_scheduled_change_removed' => ['subscription_scheduled_change_removed', SubscriptionHistoryDetailSubscriptionScheduledChangeRemoved::class];
        yield 'subscription_scheduled_change_updated' => ['subscription_scheduled_change_updated', SubscriptionHistoryDetailSubscriptionScheduledChangeUpdated::class];
    }

    /** @test */
    public function list_history_fixture_covers_every_known_action(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_history_all_actions')));
        $entries = iterator_to_array($this->client->subscriptions->listHistory('sub_01hv959anj4zrw503h2acawb3p'), false);

        $known = array_values(array_filter(SubscriptionHistoryAction::toArray()));
        $provided = array_map(fn (array $row): string => $row[0], iterator_to_array(self::historyDetailTypesProvider()));
        $hydrated = array_map(fn ($entry): string => $entry->detail->action->getValue(), $entries);

        sort($known);
        sort($provided);
        sort($hydrated);

        self::assertSame($known, array_values($provided));
        self::assertSame($known, $hydrated);
    }

    /** @test */
    public function list_history_can_paginate(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_history_paginated_page_one')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_history_paginated_page_two')));

        $collection = $this->client->subscriptions->listHistory('sub_01hv959anj4zrw503h2acawb3p');

        $request = $this->mockClient->getLastRequest();
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/subscriptions/sub_01hv959anj4zrw503h2acawb3p/history',
            urldecode((string) $request->getUri()),
        );

        $allEntries = iterator_to_array($collection, false);
        self::assertCount(4, $allEntries);

        $request = $this->mockClient->getLastRequest();
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/subscriptions/sub_01hv959anj4zrw503h2acawb3p/history?after=subhis_02paga0a4m6v7w8x9y0z1a2b3c',
            urldecode((string) $request->getUri()),
        );
    }
}
