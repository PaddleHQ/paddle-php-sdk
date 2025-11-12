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
use Paddle\SDK\Entities\Shared\PaymentMethodUnderlyingDetails;
use Paddle\SDK\Entities\Shared\Paypal;
use Paddle\SDK\Entities\Shared\SavedPaymentMethodOrigin;
use Paddle\SDK\Entities\Shared\SavedPaymentMethodType;
use Paddle\SDK\Entities\Shared\SouthKoreaLocalCard;

class PaymentMethod implements Entity
{
    private function __construct(
        public string $id,
        public string $customerId,
        public string $addressId,
        public SavedPaymentMethodType $type,
        public Card|null $card,
        public Paypal|null $paypal,
        public SouthKoreaLocalCard|null $southKoreaLocalCard,
        /** @deprecated */
        public PaymentMethodUnderlyingDetails|null $underlyingDetails,
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
            southKoreaLocalCard: isset($data['south_korea_local_card'])
                ? SouthKoreaLocalCard::from($data['south_korea_local_card'])
                : null,
            underlyingDetails: isset($data['underlying_details'])
                ? PaymentMethodUnderlyingDetails::from($data['underlying_details'])
                : null,
            origin: SavedPaymentMethodOrigin::from($data['origin']),
            savedAt: DateTime::from($data['saved_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
