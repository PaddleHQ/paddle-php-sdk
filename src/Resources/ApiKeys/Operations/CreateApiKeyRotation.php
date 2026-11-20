<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\ApiKeys\Operations;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class CreateApiKeyRotation implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly int $gracePeriodSeconds,
        public readonly \DateTimeInterface|string|Undefined $newKeyExpiresAt = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'grace_period_seconds' => $this->gracePeriodSeconds,
            'new_key_expires_at' => $this->newKeyExpiresAt instanceof \DateTimeInterface
                ? DateTime::from($this->newKeyExpiresAt)?->format()
                : $this->newKeyExpiresAt,
        ]);
    }
}
