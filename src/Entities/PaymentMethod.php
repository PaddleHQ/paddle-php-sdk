<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Shared\Card;
use Paddle\SDK\Entities\Shared\Paypal;
use Paddle\SDK\Entities\Shared\SavedPaymentMethodOrigin;
use Paddle\SDK\Entities\Shared\SavedPaymentMethodType;

class PaymentMethod implements Entity
{
    private function __construct(
        public string $id,
        public string $customerId,
        public string $addressId,
        public SavedPaymentMethodType $type,
        public Card|null $card,
        public Paypal|null $paypal,
        public SavedPaymentMethodOrigin $origin,
        public \DateTimeInterface $savedAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            customerId: $data['customer_id'],
            addressId: $data['address_id'],
            type: SavedPaymentMethodType::from($data['type']),
            card: isset($data['card']) ? Card::from($data['card']) : null,
            paypal: isset($data['paypal']) ? Paypal::from($data['paypal']) : null,
            origin: SavedPaymentMethodOrigin::from($data['origin']),
            savedAt: DateTime::from($data['saved_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
