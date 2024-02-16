<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\Entities\Shared\CurrencyCode;

class SubscriptionCharge
{
    private function __construct(
        public string $amount,
        public CurrencyCode $currencyCode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(amount: $data['amount'], currencyCode: CurrencyCode::from($data['currency_code']));
    }
}
