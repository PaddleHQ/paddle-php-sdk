<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Simulations;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Entities\Simulation\Config\Option\BusinessSimulatedAs;
use Paddle\SDK\Entities\Simulation\Config\Option\CustomerSimulatedAs;
use Paddle\SDK\Entities\Simulation\Config\Option\DiscountSimulatedAs;
use Paddle\SDK\Entities\Simulation\Config\Option\DunningExhaustedAction;
use Paddle\SDK\Entities\Simulation\Config\Option\EffectiveFrom;
use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\Entities\Simulation\SimulationStatus;
use Paddle\SDK\Environment;
use Paddle\SDK\JsonEncoder;
use Paddle\SDK\Notifications\Entities\EntityFactory;
use Paddle\SDK\Notifications\Entities\Simulation;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Shared\Operations\List\OrderBy;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Resources\Simulations\Operations\Config\SimulationConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Cancellation\SubscriptionCancellationConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Cancellation\SubscriptionCancellationEntitiesCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Cancellation\SubscriptionCancellationOptionsCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation\SubscriptionCreationConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation\SubscriptionCreationEntitiesCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation\SubscriptionCreationItemCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation\SubscriptionCreationOptionsCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Pause\SubscriptionPauseConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Pause\SubscriptionPauseEntitiesCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Pause\SubscriptionPauseOptionsCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Renewal\SubscriptionRenewalConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Renewal\SubscriptionRenewalEntitiesCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Renewal\SubscriptionRenewalOptionsCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Resume\SubscriptionResumeConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Resume\SubscriptionResumeEntitiesCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Resume\SubscriptionResumeOptionsCreate;
use Paddle\SDK\Resources\Simulations\Operations\CreateSimulation;
use Paddle\SDK\Resources\Simulations\Operations\ListSimulations;
use Paddle\SDK\Resources\Simulations\Operations\UpdateSimulation;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SimulationsClientTest extends TestCase
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
        CreateSimulation $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->simulations->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/simulations', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateSimulation(
                notificationSettingId: 'ntfset_01j82d983j814ypzx7m1fw2jpz',
                type: EventTypeName::AddressCreated(),
                name: 'New US address created for CRM',
                payload: EntityFactory::create('address.created', json_decode(self::readRawJsonFixture('request/address_created_payload'), true)),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Undefined' => [
            new CreateSimulation(
                notificationSettingId: 'ntfset_01j82d983j814ypzx7m1fw2jpz',
                type: EventTypeName::from('unknown_entity.created'),
                name: 'Some Simulation',
                payload: EntityFactory::create('unknown_entity.created', ['some' => 'data']),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            json_encode([
                'notification_setting_id' => 'ntfset_01j82d983j814ypzx7m1fw2jpz',
                'name' => 'Some Simulation',
                'type' => 'unknown_entity.created',
                'payload' => ['some' => 'data'],
            ]),
        ];

        $simulationEntities = [
            [
                new Simulation\Address(id: 'add_01hv8gq3318ktkfengj2r75gfx'),
                ['id' => 'add_01hv8gq3318ktkfengj2r75gfx'],
            ],
            [
                new Simulation\Adjustment(id: 'adj_01hvgf2s84dr6reszzg29zbvcm'),
                ['id' => 'adj_01hvgf2s84dr6reszzg29zbvcm'],
            ],
            [
                new Simulation\Business(id: 'biz_01hv8hkr641vmpwytx38znv56k'),
                ['id' => 'biz_01hv8hkr641vmpwytx38znv56k'],
            ],
            [
                new Simulation\Customer(id: 'ctm_01h844p3h41s12zs5mn4axja51'),
                ['id' => 'ctm_01h844p3h41s12zs5mn4axja51'],
            ],
            [
                new Simulation\ApiKeyExposure(id: 'apkexp_01jkas9tppn3bhadwpcyag45zd'),
                ['id' => 'apkexp_01jkas9tppn3bhadwpcyag45zd'],
            ],
            [
                new Simulation\DeletedPaymentMethod(id: 'paymtd_01hs8zx6x377xfsfrt2bqsevbw'),
                ['id' => 'paymtd_01hs8zx6x377xfsfrt2bqsevbw'],
            ],
            [
                new Simulation\Discount(id: 'dsc_01hv6scyf7qdnzcdq01t2y8dx4'),
                ['id' => 'dsc_01hv6scyf7qdnzcdq01t2y8dx4'],
            ],
            [
                new Simulation\PaymentMethod(id: 'paymtd_01hs8zx6x377xfsfrt2bqsevbw'),
                ['id' => 'paymtd_01hs8zx6x377xfsfrt2bqsevbw'],
            ],
            [
                new Simulation\Payout(id: 'pay_01gsz4vmqbjk3x4vvtafffd540'),
                ['id' => 'pay_01gsz4vmqbjk3x4vvtafffd540'],
            ],
            [
                new Simulation\Price(id: 'pri_01hv0vax6rv18t4tamj848ne4d'),
                ['id' => 'pri_01hv0vax6rv18t4tamj848ne4d'],
            ],
            [
                new Simulation\Product(id: 'pro_01htz88xpr0mm7b3ta2pjkr7w2'),
                ['id' => 'pro_01htz88xpr0mm7b3ta2pjkr7w2'],
            ],
            [
                new Simulation\Report(id: 'rep_01hvgdpayq6kjzyk4hz5m02cpn'),
                ['id' => 'rep_01hvgdpayq6kjzyk4hz5m02cpn'],
            ],
            [
                new Simulation\Subscription(id: 'sub_01hv8x29kz0t586xy6zn1a62ny'),
                ['id' => 'sub_01hv8x29kz0t586xy6zn1a62ny'],
            ],
            [
                new Simulation\Transaction(id: 'txn_01h69ddtrb11km0wk46dn607ya'),
                ['id' => 'txn_01h69ddtrb11km0wk46dn607ya'],
            ],
        ];

        foreach ($simulationEntities as [$simulationEntity, $expectedPayload]) {
            yield 'Partial payload for ' . $simulationEntity::class => [
                new CreateSimulation(
                    notificationSettingId: 'ntfset_01j82d983j814ypzx7m1fw2jpz',
                    type: EventTypeName::from('transaction.created'),
                    name: 'Some Simulation',
                    payload: $simulationEntity,
                ),
                new Response(200, body: self::readRawJsonFixture('response/full_entity')),
                json_encode([
                    'notification_setting_id' => 'ntfset_01j82d983j814ypzx7m1fw2jpz',
                    'name' => 'Some Simulation',
                    'type' => 'transaction.created',
                    'payload' => $expectedPayload,
                ]),
            ];
        }
    }

    /**
     * @test
     *
     * @dataProvider updateOperationsProvider
     */
    public function it_uses_expected_payload_on_update(
        UpdateSimulation $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->simulations->update('ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update Single' => [
            new UpdateSimulation(status: SimulationStatus::Archived()),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_single'),
        ];

        yield 'Update Partial' => [
            new UpdateSimulation(
                notificationSettingId: 'ntfset_01j82d983j814ypzx7m1fw2jpz',
                name: 'New simulation name',
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_partial'),
        ];

        yield 'Update All' => [
            new UpdateSimulation(
                notificationSettingId: 'ntfset_01j82d983j814ypzx7m1fw2jpz',
                type: EventTypeName::AdjustmentUpdated(),
                name: 'Refund approved',
                status: SimulationStatus::Active(),
                payload: EntityFactory::create('adjustment.updated', json_decode(self::readRawJsonFixture('request/adjustment_updated_payload'), true)),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_adjustment_updated')),
            self::readRawJsonFixture('request/update_full'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        ListSimulations $listOperation,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_default')));
        $this->client->simulations->list($listOperation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListSimulations(),
            sprintf('%s/simulations', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With status filter' => [
            new ListSimulations(statuses: [SimulationStatus::Active()]),
            sprintf('%s/simulations?status=active', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With default pagination' => [
            new ListSimulations(
                new Pager(),
            ),
            sprintf('%s/simulations?order_by=id[asc]&per_page=50', Environment::SANDBOX->baseUrl()),
        ];

        yield 'With pagination after' => [
            new ListSimulations(
                new Pager('ntfsim_01j82d9tc19c67jds5vzbzjcns'),
            ),
            sprintf(
                '%s/simulations?after=ntfsim_01j82d9tc19c67jds5vzbzjcns&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID asc' => [
            new ListSimulations(
                new Pager('ntfsim_01j82d9tc19c67jds5vzbzjcns', OrderBy::idAscending()),
            ),
            sprintf(
                '%s/simulations?after=ntfsim_01j82d9tc19c67jds5vzbzjcns&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID desc' => [
            new ListSimulations(
                new Pager('ntfsim_01j82d9tc19c67jds5vzbzjcns', OrderBy::idDescending()),
            ),
            sprintf(
                '%s/simulations?after=ntfsim_01j82d9tc19c67jds5vzbzjcns&order_by=id[desc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'With pagination after, order by ID asc, per page' => [
            new ListSimulations(
                new Pager('ntfsim_01j82d9tc19c67jds5vzbzjcns', OrderBy::idDescending(), 10),
            ),
            sprintf(
                '%s/simulations?after=ntfsim_01j82d9tc19c67jds5vzbzjcns&order_by=id[desc]&per_page=10',
                Environment::SANDBOX->baseUrl(),
            ),
        ];
    }

    /** @test */
    public function it_can_paginate(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_one')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_two')));

        $collection = $this->client->simulations->list();

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/simulations',
            urldecode((string) $request->getUri()),
        );

        $allSimulations = iterator_to_array($collection);
        self::assertCount(2, $allSimulations);

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/simulations?after=ntfsim_01j82fs5pvrdse93e1kawqy2fr',
            urldecode((string) $request->getUri()),
        );
    }

    /**
     * @test
     *
     * @dataProvider getRequestProvider
     */
    public function get_hits_expected_uri(
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->simulations->get('ntfsim_01j82g2mggsgjpb3mjg0xq6p5k');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function getRequestProvider(): \Generator
    {
        yield 'Default' => [
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            sprintf('%s/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', Environment::SANDBOX->baseUrl()),
        ];
    }

    /**
     * @test
     *
     * @dataProvider configDataProvider
     */
    public function it_uses_expected_payload_on_create_with_config(
        SimulationScenarioType $type,
        SimulationConfigCreate $config,
        ResponseInterface $response,
        array $expectedConfigData,
    ): void {
        $operation = new CreateSimulation(
            notificationSettingId: 'ntfset_01j82d983j814ypzx7m1fw2jpz',
            type: $type,
            name: 'Some Simulation',
            config: $config,
        );

        $this->mockClient->addResponse($response);
        $simulation = $this->client->simulations->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/simulations', urldecode((string) $request->getUri()));

        $expectedBody = json_encode([
            'notification_setting_id' => 'ntfset_01j82d983j814ypzx7m1fw2jpz',
            'type' => $type,
            'name' => 'Some Simulation',
            'config' => $expectedConfigData,
        ]);

        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
        self::assertEquals(
            json_decode((string) $response->getBody(), true)['data'],
            json_decode(JsonEncoder::default()->encode($simulation), true),
        );
    }

    /**
     * @test
     *
     * @dataProvider configDataProvider
     */
    public function it_uses_expected_payload_on_update_with_config(
        SimulationScenarioType $type,
        SimulationConfigCreate $config,
        ResponseInterface $response,
        array $expectedConfigData,
    ): void {
        $operation = new UpdateSimulation(
            notificationSettingId: 'ntfset_01j82d983j814ypzx7m1fw2jpz',
            type: $type,
            name: 'Some Simulation',
            config: $config,
        );

        $this->mockClient->addResponse($response);
        $simulation = $this->client->simulations->update('ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/simulations/ntfsim_01j82g2mggsgjpb3mjg0xq6p5k', urldecode((string) $request->getUri()));

        $expectedBody = json_encode([
            'notification_setting_id' => 'ntfset_01j82d983j814ypzx7m1fw2jpz',
            'type' => $type,
            'name' => 'Some Simulation',
            'config' => $expectedConfigData,
        ]);

        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
        self::assertEquals(
            json_decode((string) $response->getBody(), true)['data'],
            json_decode(JsonEncoder::default()->encode($simulation), true),
        );
    }

    public static function configDataProvider(): \Generator
    {
        yield 'Subscription creation simulation - transaction ID and new customer' => [
            SimulationScenarioType::SubscriptionCreation(),
            new SubscriptionCreationConfigCreate(
                entities: new SubscriptionCreationEntitiesCreate(
                    customerId: 'ctm_01h04vsc0qhwtsbsxh3422wjs4',
                    addressId: 'add_01h04vsc0qhwtsbsxh3422wjs4',
                    businessId: 'biz_01h04vsc0qhwtsbsxh3422wjs4',
                    paymentMethodId: 'paymtd_01h04vsc0qhwtsbsxh3422wjs4',
                    discountId: 'dsc_01h04vsc0qhwtsbsxh3422wjs4',
                    transactionId: 'txn_01h04vsc0qhwtsbsxh3422wjs4',
                ),
                options: new SubscriptionCreationOptionsCreate(
                    customerSimulatedAs: CustomerSimulatedAs::New(),
                    businessSimulatedAs: BusinessSimulatedAs::New(),
                    discountSimulatedAs: DiscountSimulatedAs::NotProvided(),
                ),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_subscription_creation_txn_id')),
            self::readJsonFixture('request/config/subscription_creation_txn_id'),
        ];

        yield 'Subscription creation simulation - items and new customer' => [
            SimulationScenarioType::SubscriptionCreation(),
            new SubscriptionCreationConfigCreate(
                entities: new SubscriptionCreationEntitiesCreate(
                    customerId: 'ctm_01h04vsc0qhwtsbsxh3422wjs4',
                    addressId: 'add_01h04vsc0qhwtsbsxh3422wjs4',
                    businessId: 'biz_01h04vsc0qhwtsbsxh3422wjs4',
                    paymentMethodId: 'paymtd_01h04vsc0qhwtsbsxh3422wjs4',
                    discountId: 'dsc_01h04vsc0qhwtsbsxh3422wjs4',
                    items: [
                        new SubscriptionCreationItemCreate(
                            priceId: 'pri_01h04vsc0qhwtsbsxh3422wjs4',
                            quantity: 1,
                        ),
                    ],
                ),
                options: new SubscriptionCreationOptionsCreate(
                    customerSimulatedAs: CustomerSimulatedAs::New(),
                    businessSimulatedAs: BusinessSimulatedAs::New(),
                    discountSimulatedAs: DiscountSimulatedAs::NotProvided(),
                ),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_subscription_creation')),
            self::readJsonFixture('request/config/subscription_creation_new_customer'),
        ];

        yield 'Subscription creation simulation - matching customer' => [
            SimulationScenarioType::SubscriptionCreation(),
            new SubscriptionCreationConfigCreate(
                entities: new SubscriptionCreationEntitiesCreate(
                    customerId: 'ctm_01h04vsc0qhwtsbsxh3422wjs4',
                    addressId: 'add_01h04vsc0qhwtsbsxh3422wjs4',
                    businessId: 'biz_01h04vsc0qhwtsbsxh3422wjs4',
                    paymentMethodId: 'paymtd_01h04vsc0qhwtsbsxh3422wjs4',
                    discountId: 'dsc_01h04vsc0qhwtsbsxh3422wjs4',
                    items: [
                        new SubscriptionCreationItemCreate(
                            priceId: 'pri_01h04vsc0qhwtsbsxh3422wjs4',
                            quantity: 1,
                        ),
                    ],
                ),
                options: new SubscriptionCreationOptionsCreate(
                    customerSimulatedAs: CustomerSimulatedAs::ExistingEmailMatched(),
                    businessSimulatedAs: BusinessSimulatedAs::NotProvided(),
                    discountSimulatedAs: DiscountSimulatedAs::EnteredByCustomer(),
                ),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_subscription_creation')),
            self::readJsonFixture('request/config/subscription_creation_matching_customer'),
        ];

        yield 'Subscription creation simulation - prefilled customer' => [
            SimulationScenarioType::SubscriptionCreation(),
            new SubscriptionCreationConfigCreate(
                entities: new SubscriptionCreationEntitiesCreate(
                    customerId: 'ctm_01h04vsc0qhwtsbsxh3422wjs4',
                    addressId: 'add_01h04vsc0qhwtsbsxh3422wjs4',
                    businessId: 'biz_01h04vsc0qhwtsbsxh3422wjs4',
                    paymentMethodId: 'paymtd_01h04vsc0qhwtsbsxh3422wjs4',
                    discountId: 'dsc_01h04vsc0qhwtsbsxh3422wjs4',
                    items: [
                        new SubscriptionCreationItemCreate(
                            priceId: 'pri_01h04vsc0qhwtsbsxh3422wjs4',
                            quantity: 1,
                        ),
                    ],
                ),
                options: new SubscriptionCreationOptionsCreate(
                    customerSimulatedAs: CustomerSimulatedAs::ExistingDetailsPrefilled(),
                    businessSimulatedAs: BusinessSimulatedAs::ExistingDetailsPrefilled(),
                    discountSimulatedAs: DiscountSimulatedAs::NotProvided(),
                ),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_subscription_creation')),
            self::readJsonFixture('request/config/subscription_creation_prefilled_customer'),
        ];

        yield 'Subscription creation simulation - minimal' => [
            SimulationScenarioType::SubscriptionCreation(),
            new SubscriptionCreationConfigCreate(
                entities: new SubscriptionCreationEntitiesCreate(),
                options: new SubscriptionCreationOptionsCreate(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_subscription_creation')),
            [
                'subscription_creation' => [
                    'entities' => (object) [],
                    'options' => (object) [],
                ],
            ],
        ];

        yield 'Subscription renewal simulation with success outcome' => [
            SimulationScenarioType::SubscriptionRenewal(),
            new SubscriptionRenewalConfigCreate(
                entities: new SubscriptionRenewalEntitiesCreate(
                    subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ),
                options: SubscriptionRenewalOptionsCreate::forSuccessfulPayment(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_renewal_success')),
            self::readJsonFixture('request/config/subscription_renewal_success'),
        ];

        yield 'Subscription renewal simulation with success outcome - minimal' => [
            SimulationScenarioType::SubscriptionRenewal(),
            new SubscriptionRenewalConfigCreate(
                entities: new SubscriptionRenewalEntitiesCreate(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_renewal_success')),
            [
                'subscription_renewal' => [
                    'entities' => (object) [],
                ],
            ],
        ];

        yield 'Subscription renewal simulation with failed outcome' => [
            SimulationScenarioType::SubscriptionRenewal(),
            new SubscriptionRenewalConfigCreate(
                entities: new SubscriptionRenewalEntitiesCreate(
                    subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ),
                options: SubscriptionRenewalOptionsCreate::forFailedPayment(
                    DunningExhaustedAction::SubscriptionCanceled(),
                ),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_renewal_failed')),
            self::readJsonFixture('request/config/subscription_renewal_failed'),
        ];

        yield 'Subscription renewal simulation with recovered updated payment method' => [
            SimulationScenarioType::SubscriptionRenewal(),
            new SubscriptionRenewalConfigCreate(
                entities: new SubscriptionRenewalEntitiesCreate(
                    subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ),
                options: SubscriptionRenewalOptionsCreate::forRecoveredUpdatedPaymentMethod(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_renewal_recovered')),
            self::readJsonFixture('request/config/subscription_renewal_recovered'),
        ];

        yield 'Subscription renewal simulation with recovered existing payment method' => [
            SimulationScenarioType::SubscriptionRenewal(),
            new SubscriptionRenewalConfigCreate(
                entities: new SubscriptionRenewalEntitiesCreate(
                    subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ),
                options: SubscriptionRenewalOptionsCreate::forRecoveredExistingPaymentMethod(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_renewal_recovered_existing')),
            self::readJsonFixture('request/config/subscription_renewal_recovered_existing'),
        ];

        yield 'Subscription resume simulation with success outcome' => [
            SimulationScenarioType::SubscriptionResume(),
            new SubscriptionResumeConfigCreate(
                entities: new SubscriptionResumeEntitiesCreate(
                    subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ),
                options: SubscriptionResumeOptionsCreate::forSuccessfulPayment(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_resume_success')),
            self::readJsonFixture('request/config/subscription_resume_success'),
        ];

        yield 'Subscription resume simulation with - minimal' => [
            SimulationScenarioType::SubscriptionResume(),
            new SubscriptionResumeConfigCreate(
                entities: new SubscriptionResumeEntitiesCreate(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_resume_success')),
            [
                'subscription_resume' => [
                    'entities' => (object) [],
                ],
            ],
        ];

        yield 'Subscription resume simulation with failed outcome' => [
            SimulationScenarioType::SubscriptionResume(),
            new SubscriptionResumeConfigCreate(
                entities: new SubscriptionResumeEntitiesCreate(
                    subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ),
                options: SubscriptionResumeOptionsCreate::forFailedPayment(
                    DunningExhaustedAction::SubscriptionPaused(),
                ),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_resume_failed')),
            self::readJsonFixture('request/config/subscription_resume_failed'),
        ];

        yield 'Subscription resume simulation with recovered updated payment method' => [
            SimulationScenarioType::SubscriptionResume(),
            new SubscriptionResumeConfigCreate(
                entities: new SubscriptionResumeEntitiesCreate(
                    subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ),
                options: SubscriptionResumeOptionsCreate::forRecoveredUpdatedPaymentMethod(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_resume_recovered')),
            self::readJsonFixture('request/config/subscription_resume_recovered'),
        ];

        yield 'Subscription resume simulation with recovered existing payment method' => [
            SimulationScenarioType::SubscriptionResume(),
            new SubscriptionResumeConfigCreate(
                entities: new SubscriptionResumeEntitiesCreate(
                    subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ),
                options: SubscriptionResumeOptionsCreate::forRecoveredExistingPaymentMethod(),
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity_config_resume_recovered_existing')),
            self::readJsonFixture('request/config/subscription_resume_recovered_existing'),
        ];

        yield 'Subscription pause simulation' => [
            SimulationScenarioType::SubscriptionPause(),
            new SubscriptionPauseConfigCreate(
                entities: new SubscriptionPauseEntitiesCreate(
                    subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ),
                options: new SubscriptionPauseOptionsCreate(
                    effectiveFrom: EffectiveFrom::NextBillingPeriod(),
                    hasPastDueTransaction: false,
                ),
            ),
            new Response(201, body: self::readRawJsonFixture('response/full_entity_config_pause')),
            self::readJsonFixture('request/config/subscription_pause'),
        ];

        yield 'Subscription pause simulation - minimal' => [
            SimulationScenarioType::SubscriptionPause(),
            new SubscriptionPauseConfigCreate(
                entities: new SubscriptionPauseEntitiesCreate(),
                options: new SubscriptionPauseOptionsCreate(),
            ),
            new Response(201, body: self::readRawJsonFixture('response/full_entity_config_pause')),
            [
                'subscription_pause' => [
                    'entities' => (object) [],
                    'options' => (object) [],
                ],
            ],
        ];

        yield 'Subscription cancellation simulation' => [
            SimulationScenarioType::SubscriptionCancellation(),
            new SubscriptionCancellationConfigCreate(
                entities: new SubscriptionCancellationEntitiesCreate(
                    subscriptionId: 'sub_01h04vsc0qhwtsbsxh3422wjs4',
                ),
                options: new SubscriptionCancellationOptionsCreate(
                    effectiveFrom: EffectiveFrom::NextBillingPeriod(),
                    hasPastDueTransaction: false,
                ),
            ),
            new Response(201, body: self::readRawJsonFixture('response/full_entity_config_cancel')),
            self::readJsonFixture('request/config/subscription_cancel'),
        ];

        yield 'Subscription cancellation simulation - minimal' => [
            SimulationScenarioType::SubscriptionCancellation(),
            new SubscriptionCancellationConfigCreate(
                entities: new SubscriptionCancellationEntitiesCreate(),
                options: new SubscriptionCancellationOptionsCreate(),
            ),
            new Response(201, body: self::readRawJsonFixture('response/full_entity_config_cancel')),
            [
                'subscription_cancellation' => [
                    'entities' => (object) [],
                    'options' => (object) [],
                ],
            ],
        ];
    }
}
