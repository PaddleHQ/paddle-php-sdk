<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\Entities\Product;
use Paddle\SDK\Entities\Shared\Totals;
use Paddle\SDK\Entities\Shared\UnitTotals;

class SubscriptionTransactionLineItem
{
    private function __construct(
        public string $id,
        public string $priceId,
        public int $quantity,
        public SubscriptionProration $proration,
        public string $taxRate,
        public UnitTotals $unitTotals,
        public Totals $totals,
        public Product $product,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            priceId: $data['price_id'],
            quantity: $data['quantity'],
            proration: SubscriptionProration::from($data['proration']),
            taxRate: $data['tax_rate'],
            unitTotals: UnitTotals::from($data['unit_totals']),
            totals: Totals::from($data['totals']),
            product: Product::from($data['product']),
        );
    }
}
