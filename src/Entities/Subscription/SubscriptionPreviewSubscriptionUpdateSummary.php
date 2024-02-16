<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

class SubscriptionPreviewSubscriptionUpdateSummary
{
    private function __construct(
        public SubscriptionCredit $credit,
        public SubscriptionCharge $charge,
        public SubscriptionResult $result,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            SubscriptionCredit::from($data['credit']),
            SubscriptionCharge::from($data['charge']),
            SubscriptionResult::from($data['result']),
        );
    }
}
