<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

class TransactionUpdateTransactionItem
{
    public function __construct(
        public string $priceId,
        public int $quantity,
    ) {
    }
}
