<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\SubscriptionHistory\SubscriptionHistoryReason;
use PHPUnit\Framework\TestCase;

class SubscriptionHistoryReasonTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider reasonsProvider
     */
    public function it_hydrates_known_reasons(string $value, SubscriptionHistoryReason $expected): void
    {
        $reason = SubscriptionHistoryReason::from($value);

        self::assertEquals($expected, $reason);
        self::assertTrue($reason->isKnown());
        self::assertSame($value, $reason->getValue());
    }

    public static function reasonsProvider(): \Generator
    {
        yield 'cardless_trial_ended' => ['cardless_trial_ended', SubscriptionHistoryReason::CardlessTrialEnded()];
        yield 'import_issue' => ['import_issue', SubscriptionHistoryReason::ImportIssue()];
        yield 'missing_consent' => ['missing_consent', SubscriptionHistoryReason::MissingConsent()];
        yield 'seller_request' => ['seller_request', SubscriptionHistoryReason::SellerRequest()];
        yield 'customer_request' => ['customer_request', SubscriptionHistoryReason::CustomerRequest()];
        yield 'chargeback' => ['chargeback', SubscriptionHistoryReason::Chargeback()];
        yield 'eu_withdrawal' => ['eu_withdrawal', SubscriptionHistoryReason::EuWithdrawal()];
    }

    /** @test */
    public function it_hydrates_unknown_reasons_as_undefined(): void
    {
        $reason = SubscriptionHistoryReason::from('some_new_reason');

        self::assertFalse($reason->isKnown());
        self::assertSame('some_new_reason', $reason->getValue());
    }
}
