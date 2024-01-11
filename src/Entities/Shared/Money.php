<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class Money
{
    public function __construct(
        public string $amount,
        public CurrencyCode|null $currencyCode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            amount: $data['amount'],
            currencyCode: isset($data['currency_code']) && $data['currency_code'] !== ''
                ? CurrencyCode::from($data['currency_code'])
                : null,
        );
    }
}
