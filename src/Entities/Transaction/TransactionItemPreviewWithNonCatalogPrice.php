<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

class TransactionItemPreviewWithNonCatalogPrice
{
    public function __construct(
        public TransactionNonCatalogPrice|TransactionNonCatalogPriceWithProduct $price,
        public int $quantity,
        public bool|null $includeInTotals,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['price'],
            $data['quantity'],
            $data['include_in_totals'] ?? null,
        );
    }
}
