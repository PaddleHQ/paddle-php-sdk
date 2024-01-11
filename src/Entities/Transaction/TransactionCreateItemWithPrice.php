<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

class TransactionCreateItemWithPrice
{
    public function __construct(
        public TransactionNonCatalogPrice|TransactionNonCatalogPriceWithProduct $price,
        public int $quantity,
    ) {
    }
}
