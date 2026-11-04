<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Subscription;

use Paddle\SDK\Notifications\Entities\DateTime;

class SubscriptionDiscount implements \JsonSerializable
{
    private function __construct(
        public string $id,
        public \DateTimeInterface|null $startsAt,
        public \DateTimeInterface|null $endsAt,
        public SubscriptionDiscountType|null $type = null,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            isset($data['starts_at']) ? DateTime::from($data['starts_at']) : null,
            isset($data['ends_at']) ? DateTime::from($data['ends_at']) : null,
            isset($data['type']) ? SubscriptionDiscountType::from($data['type']) : null,
        );
    }

    public function jsonSerialize(): array
    {
        $data = [
            'id' => $this->id,
            'starts_at' => $this->startsAt,
            'ends_at' => $this->endsAt,
        ];

        // Simulation payloads are validated against a schema that only accepts a known type, so leave it out when unset.
        if ($this->type !== null) {
            $data['type'] = $this->type;
        }

        return $data;
    }
}
