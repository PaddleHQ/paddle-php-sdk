<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Renewal;

use Paddle\SDK\Entities\Simulation\Config\Option\DunningExhaustedAction;
use Paddle\SDK\Entities\Simulation\Config\Option\PaymentOutcome;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class SubscriptionRenewalOptionsCreate implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly PaymentOutcome|Undefined $paymentOutcome = new Undefined(),
        public readonly DunningExhaustedAction|Undefined|null $dunningExhaustedAction = new Undefined(),
    ) {
    }

    public function jsonSerialize(): \stdClass
    {
        return (object) $this->filterUndefined([
            'payment_outcome' => $this->paymentOutcome,
            'dunning_exhausted_action' => $this->dunningExhaustedAction,
        ]);
    }

    public static function forSuccessfulPayment(): self
    {
        return new self(
            PaymentOutcome::Success(),
        );
    }

    public static function forFailedPayment(DunningExhaustedAction|Undefined $dunningExhaustedAction = new Undefined()): self
    {
        return new self(
            PaymentOutcome::Failed(),
            $dunningExhaustedAction,
        );
    }

    public static function forRecoveredExistingPaymentMethod(): self
    {
        return new self(
            PaymentOutcome::RecoveredExistingPaymentMethod(),
        );
    }

    public static function forRecoveredUpdatedPaymentMethod(): self
    {
        return new self(
            PaymentOutcome::RecoveredUpdatedPaymentMethod(),
        );
    }
}
