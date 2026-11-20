<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Discount;

class SubscriptionHistoryDiscount
{
    private function __construct(
        public Discount $discount,
        public SubscriptionHistoryDiscountType $type,
        public \DateTimeInterface $startsAt,
        public \DateTimeInterface|null $endsAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            discount: Discount::from($data['discount']),
            type: SubscriptionHistoryDiscountType::from($data['type']),
            startsAt: DateTime::from($data['starts_at']),
            endsAt: isset($data['ends_at']) ? DateTime::from($data['ends_at']) : null,
        );
    }
}
