<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class PriceTrialPeriod extends TimePeriod
{
    /**
     * @param array<UnitPriceOverride> $unitPriceOverrides
     */
    private function __construct(
        public Interval $interval,
        public int $frequency,
        public bool $requiresPaymentMethod,
        public Money|null $unitPrice,
        public array $unitPriceOverrides,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            interval: Interval::from($data['interval']),
            frequency: $data['frequency'],
            requiresPaymentMethod: $data['requires_payment_method'] ?? true,
            unitPrice: isset($data['unit_price']) ? Money::from($data['unit_price']) : null,
            unitPriceOverrides: array_map(
                fn (array $override): UnitPriceOverride => UnitPriceOverride::from($override),
                $data['unit_price_overrides'] ?? [],
            ),
        );
    }
}
