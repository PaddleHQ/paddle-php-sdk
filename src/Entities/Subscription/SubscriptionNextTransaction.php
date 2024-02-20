<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\Entities\Shared\TransactionDetailsPreview;

class SubscriptionNextTransaction
{
    /**
     * @param array<SubscriptionAdjustmentPreview> $adjustments
     */
    private function __construct(
        public SubscriptionTimePeriod $billingPeriod,
        public TransactionDetailsPreview $details,
        public array $adjustments,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            billingPeriod: SubscriptionTimePeriod::from($data['billing_period']),
            details: TransactionDetailsPreview::from($data['details']),
            adjustments: array_map(
                fn (array $adjustment) => SubscriptionAdjustmentPreview::from($adjustment),
                $data['adjustments'],
            ),
        );
    }
}
