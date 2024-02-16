<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

use Paddle\SDK\Notifications\Entities\Transaction\TransactionCardType;

class Card
{
    private function __construct(
        public TransactionCardType $type,
        public string $last4,
        public int $expiryMonth,
        public int $expiryYear,
        public string|null $cardholderName,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            TransactionCardType::from($data['type']),
            $data['last4'],
            $data['expiry_month'],
            $data['expiry_year'],
            $data['cardholder_name'] ?? null,
        );
    }
}
