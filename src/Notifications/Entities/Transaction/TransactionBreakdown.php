<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Transaction;

class TransactionBreakdown
{
    private function __construct(
        public string $credit,
        public string $refund,
        public string $chargeback,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data['credit'], $data['refund'], $data['chargeback']);
    }
}
