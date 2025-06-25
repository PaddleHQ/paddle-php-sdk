<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Simulation\Config\Subscription\Renewal;

use Paddle\SDK\Entities\Simulation\Config\Option\DunningExhaustedAction;
use Paddle\SDK\Entities\Simulation\Config\Option\PaymentOutcome;

class SubscriptionRenewalOptions
{
    private function __construct(
        public readonly PaymentOutcome $paymentOutcome,
        public readonly DunningExhaustedAction|null $dunningExhaustedAction,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            paymentOutcome: PaymentOutcome::from($data['payment_outcome']),
            dunningExhaustedAction: isset($data['dunning_exhausted_action'])
                ? DunningExhaustedAction::from($data['dunning_exhausted_action'])
                : null,
        );
    }
}
