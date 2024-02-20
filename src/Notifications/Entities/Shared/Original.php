<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class Original
{
    private function __construct(
        public string $amount,
        public CurrencyCodeAdjustments $currencyCode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data['amount'], CurrencyCodeAdjustments::from($data['currency_code']));
    }
}
