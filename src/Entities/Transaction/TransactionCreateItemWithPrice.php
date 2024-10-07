<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

/**
 * @deprecated Replaced by \Paddle\SDK\Resources\Transactions\Operations\Create\TransactionCreateItemWithPrice
 */
class TransactionCreateItemWithPrice
{
    public function __construct(
        public TransactionNonCatalogPrice|TransactionNonCatalogPriceWithProduct $price,
        public int $quantity,
    ) {
    }
}
