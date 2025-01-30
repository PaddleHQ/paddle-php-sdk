<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\Shared\SavedPaymentMethodDeletionReason;
use Paddle\SDK\Notifications\Entities\Shared\SavedPaymentMethodOrigin;
use Paddle\SDK\Notifications\Entities\Shared\SavedPaymentMethodType;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

final class DeletedPaymentMethod implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly string|Undefined $customerId = new Undefined(),
        public readonly string|Undefined $addressId = new Undefined(),
        public readonly SavedPaymentMethodType|Undefined $type = new Undefined(),
        public readonly SavedPaymentMethodOrigin|Undefined $origin = new Undefined(),
        public readonly \DateTimeInterface|Undefined $savedAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined $updatedAt = new Undefined(),
        public readonly SavedPaymentMethodDeletionReason|Undefined $deletionReason = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            customerId: self::optional($data, 'customer_id'),
            addressId: self::optional($data, 'address_id'),
            type: self::optional($data, 'type', fn ($value) => SavedPaymentMethodType::from($value)),
            origin: self::optional($data, 'origin', fn ($value) => SavedPaymentMethodOrigin::from($value)),
            savedAt: self::optional($data, 'saved_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
            deletionReason: self::optional($data, 'deletion_reason', fn ($value) => SavedPaymentMethodDeletionReason::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'customer_id' => $this->customerId,
            'address_id' => $this->addressId,
            'type' => $this->type,
            'origin' => $this->origin,
            'saved_at' => $this->savedAt,
            'updated_at' => $this->updatedAt,
            'deletion_reason' => $this->deletionReason,
        ]);
    }
}
