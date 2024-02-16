<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\Entities\Product;

class TransactionLineItemPreview
{
    private function __construct(
        public string $priceId,
        public int $quantity,
        public string $taxRate,
        public UnitTotals $unitTotals,
        public Totals $totals,
        public Product $product,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['price_id'],
            $data['quantity'],
            $data['tax_rate'],
            UnitTotals::from($data['unit_totals']),
            Totals::from($data['totals']),
            Product::from($data['product']),
        );
    }
}
