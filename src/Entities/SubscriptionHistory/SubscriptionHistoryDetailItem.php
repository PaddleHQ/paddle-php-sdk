<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\Price;

class SubscriptionHistoryDetailItem
{
    private function __construct(
        public Price $price,
        public int $quantity,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            price: Price::from($data['price']),
            quantity: $data['quantity'],
        );
    }
}
