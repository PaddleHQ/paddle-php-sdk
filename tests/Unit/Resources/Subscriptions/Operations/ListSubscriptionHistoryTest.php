<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Resources\Subscriptions\Operations;

use Paddle\SDK\Entities\Shared\ActionSource;
use Paddle\SDK\Entities\Shared\ActorType;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryAction;
use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryReason;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\Resources\Shared\Operations\List\Comparator;
use Paddle\SDK\Resources\Shared\Operations\List\DateComparison;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Resources\Subscriptions\Operations\ListSubscriptionHistory;
use PHPUnit\Framework\TestCase;

class ListSubscriptionHistoryTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider parametersProvider
     */
    public function it_returns_expected_parameters(ListSubscriptionHistory $operation, array $expected): void
    {
        self::assertSame($expected, $operation->getParameters());
    }

    public static function parametersProvider(): \Generator
    {
        yield 'Default' => [new ListSubscriptionHistory(), []];

        yield 'Pager' => [new ListSubscriptionHistory(new Pager()), ['order_by' => 'id[asc]', 'per_page' => 50]];

        yield 'Single action' => [
            new ListSubscriptionHistory(actions: [SubscriptionHistoryAction::SubscriptionRenewed()]),
            ['action' => 'subscription_renewed'],
        ];

        yield 'Multiple actions' => [
            new ListSubscriptionHistory(actions: [
                SubscriptionHistoryAction::SubscriptionRenewed(),
                SubscriptionHistoryAction::SubscriptionPaused(),
            ]),
            ['action' => 'subscription_renewed,subscription_paused'],
        ];

        yield 'Sources' => [
            new ListSubscriptionHistory(sources: [ActionSource::Api(), ActionSource::Dashboard()]),
            ['source' => 'api,dashboard'],
        ];

        yield 'Actor types' => [
            new ListSubscriptionHistory(actorTypes: [ActorType::ApiKey()]),
            ['actor_type' => 'api_key'],
        ];

        yield 'Actor IDs' => [
            new ListSubscriptionHistory(actorIds: ['apikey_01h8441jn5pcwrfhwh78jqt8hl', 'usr_01h8441jn5']),
            ['actor_id' => 'apikey_01h8441jn5pcwrfhwh78jqt8hl,usr_01h8441jn5'],
        ];

        yield 'Reasons' => [
            new ListSubscriptionHistory(reasons: [SubscriptionHistoryReason::CustomerRequest(), SubscriptionHistoryReason::EuWithdrawal()]),
            ['reason' => 'customer_request,eu_withdrawal'],
        ];

        yield 'Occurred at with comparator' => [
            new ListSubscriptionHistory(occurredAt: new DateComparison(new \DateTime('2026-06-01 00:00:00'), Comparator::GTE())),
            ['occurred_at[GTE]' => '2026-06-01T00:00:00.000000Z'],
        ];

        yield 'Occurred at without comparator' => [
            new ListSubscriptionHistory(occurredAt: new DateComparison(new \DateTime('2026-06-01 00:00:00'))),
            ['occurred_at' => '2026-06-01T00:00:00.000000Z'],
        ];
    }

    /**
     * @test
     *
     * @dataProvider invalidArgumentsProvider
     */
    public function it_validates_array_types(array $arguments, string $expectedMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($expectedMessage);

        new ListSubscriptionHistory(...$arguments);
    }

    public static function invalidArgumentsProvider(): \Generator
    {
        yield 'Actions' => [
            ['actions' => ['subscription_renewed']],
            'expected actions to only contain only type/s ' . SubscriptionHistoryAction::class . ', subscription_renewed given',
        ];

        yield 'Sources' => [
            ['sources' => ['api']],
            'expected sources to only contain only type/s ' . ActionSource::class . ', api given',
        ];

        yield 'Actor types' => [
            ['actorTypes' => ['api_key']],
            'expected actorTypes to only contain only type/s ' . ActorType::class . ', api_key given',
        ];

        yield 'Actor IDs' => [
            ['actorIds' => [1]],
            'expected actorIds to only contain only type/s string, 1 given',
        ];

        yield 'Reasons' => [
            ['reasons' => ['customer_request']],
            'expected reasons to only contain only type/s ' . SubscriptionHistoryReason::class . ', customer_request given',
        ];
    }
}
