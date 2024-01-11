<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

use Paddle\SDK\Entities\ProductWithIncludes;
use Paddle\SDK\Entities\Shared\Totals;
use Paddle\SDK\Entities\Shared\UnitTotals;

class TransactionLineItem
{
    public function __construct(
        public string $id,
        public string $priceId,
        public int $quantity,
        public TransactionProration|null $proration,
        public string $taxRate,
        public UnitTotals $unitTotals,
        public Totals $totals,
        public ProductWithIncludes $product,
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
            ProductWithIncludes::from($data['product']),
        );
    }
}
