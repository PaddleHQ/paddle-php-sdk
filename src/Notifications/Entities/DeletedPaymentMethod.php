<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Shared\SavedPaymentMethodDeletionReason;
use Paddle\SDK\Notifications\Entities\Shared\SavedPaymentMethodOrigin;
use Paddle\SDK\Notifications\Entities\Shared\SavedPaymentMethodType;

class DeletedPaymentMethod implements Entity
{
    private function __construct(
        public string $id,
        public string $customerId,
        public string $addressId,
        public SavedPaymentMethodType $type,
        public SavedPaymentMethodOrigin $origin,
        public \DateTimeInterface|null $savedAt,
        public \DateTimeInterface|null $updatedAt,
        public SavedPaymentMethodDeletionReason $deletionReason,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            customerId: $data['customer_id'],
            addressId: $data['address_id'],
            type: SavedPaymentMethodType::from($data['type']),
            origin: SavedPaymentMethodOrigin::from($data['origin']),
            savedAt: isset($data['saved_at']) ? DateTime::from($data['saved_at']) : null,
            updatedAt: isset($data['updated_at']) ? DateTime::from($data['updated_at']) : null,
            deletionReason: SavedPaymentMethodDeletionReason::from($data['deletion_reason']),
        );
    }
}
