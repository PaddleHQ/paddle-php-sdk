<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\Payout\PayoutStatus;
use Paddle\SDK\Notifications\Entities\Shared\CurrencyCodePayouts;

class Payout implements Entity
{
    private function __construct(
        public string $id,
        public PayoutStatus $status,
        public string $amount,
        public CurrencyCodePayouts $currencyCode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            PayoutStatus::from($data['status']),
            $data['amount'],
            CurrencyCodePayouts::from($data['currency_code']),
        );
    }
}
