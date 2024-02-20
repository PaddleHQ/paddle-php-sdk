<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\PricingPreview;

use Paddle\SDK\Entities\Discount;

class PricePreviewDiscounts
{
    private function __construct(
        public Discount $discount,
        public string $total,
        public string $formattedTotal,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            Discount::from($data['discount']),
            $data['total'],
            $data['formatted_total'],
        );
    }
}
