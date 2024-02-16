<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

use Paddle\SDK\Entities\Price;

class TransactionItemPreviewWithPrice
{
    private function __construct(
        public Price $price,
        public int $quantity,
        public bool $includeInTotals,
        public TransactionProration|null $proration,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            Price::from($data['price']),
            $data['quantity'],
            $data['include_in_totals'],
            isset($data['proration']) ? TransactionProration::from($data['proration']) : null,
        );
    }
}
