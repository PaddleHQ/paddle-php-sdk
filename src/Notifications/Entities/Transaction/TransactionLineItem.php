<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Transaction;

use Paddle\SDK\Notifications\Entities\Product;
use Paddle\SDK\Notifications\Entities\Shared\Totals;
use Paddle\SDK\Notifications\Entities\Shared\UnitTotals;

class TransactionLineItem
{
    private function __construct(
        public string $id,
        public string $priceId,
        public int $quantity,
        public TransactionProration|null $proration,
        public string $taxRate,
        public UnitTotals $unitTotals,
        public Totals $totals,
        public Product $product,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            $data['price_id'],
            $data['quantity'],
            isset($data['proration']) ? TransactionProration::from($data['proration']) : null,
            $data['tax_rate'],
            UnitTotals::from($data['unit_totals']),
            Totals::from($data['totals']),
            Product::from($data['product']),
        );
    }
}
