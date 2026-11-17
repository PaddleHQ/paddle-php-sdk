<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class PriceTrialPeriod extends TimePeriod implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<UnitPriceOverride>|Undefined $unitPriceOverrides
     */
    public function __construct(
        Interval $interval,
        int $frequency,
        public bool|Undefined $requiresPaymentMethod = new Undefined(),
        public Money|Undefined|null $unitPrice = new Undefined(),
        public array|Undefined $unitPriceOverrides = new Undefined(),
    ) {
        parent::__construct($interval, $frequency);
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

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'interval' => $this->interval,
            'frequency' => $this->frequency,
            'requires_payment_method' => $this->requiresPaymentMethod,
            'unit_price' => $this->unitPrice,
            'unit_price_overrides' => $this->unitPriceOverrides,
        ]);
    }
}
