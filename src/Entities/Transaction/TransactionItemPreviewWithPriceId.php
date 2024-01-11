<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

class TransactionItemPreviewWithPriceId
{
    public function __construct(
        public string $priceId,
        public int $quantity,
        public bool|null $includeInTotals,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['price_id'],
            $data['quantity'],
            $data['include_in_totals'] ?? null,
        );
    }
}
