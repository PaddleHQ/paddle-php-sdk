<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\TaxMode;
use Paddle\SDK\Entities\Shared\TimePeriod;

class SubscriptionPrice
{
    private function __construct(
        public string $id,
        public string $description,
        public string $productId,
        public TimePeriod|null $billingCycle,
        public TimePeriod|null $trialPeriod,
        public TaxMode $taxMode,
        public Money $unitPrice,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            description: $data['description'],
            productId: $data['product_id'],
            billingCycle: isset($data['billing_cycle']) ? TimePeriod::from($data['billing_cycle']) : null,
            trialPeriod: isset($data['trial_period']) ? TimePeriod::from($data['trial_period']) : null,
            taxMode: TaxMode::from($data['tax_mode']),
            unitPrice: Money::from($data['unit_price']),
        );
    }
}
