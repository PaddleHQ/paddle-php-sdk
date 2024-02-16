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

class TransactionItem
{
    private function __construct(
        public string|null $priceId,
        public Price $price,
        public int $quantity,
        public TransactionProration|null $proration,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['price_id'] ?? null,
            Price::from($data['price']),
            $data['quantity'],
            isset($data['proration']) ? TransactionProration::from($data['proration']) : null,
        );
    }
}
