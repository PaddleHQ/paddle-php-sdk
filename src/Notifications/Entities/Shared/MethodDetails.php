<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

class MethodDetails
{
    private function __construct(
        public PaymentMethodType $type,
        public Card|null $card,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            PaymentMethodType::from($data['type']),
            isset($data['card']) ? Card::from($data['card']) : null,
        );
    }
}
