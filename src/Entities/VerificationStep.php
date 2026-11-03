<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Verification\VerificationStepKey;
use Paddle\SDK\Entities\Verification\VerificationStepStatus;

class VerificationStep implements Entity
{
    private function __construct(
        public string $id,
        public VerificationStepKey $key,
        public VerificationStepStatus $status,
        public \DateTimeInterface|null $expiresAt,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            key: VerificationStepKey::from($data['key']),
            status: VerificationStepStatus::from($data['status']),
            expiresAt: isset($data['expires_at']) ? DateTime::from($data['expires_at']) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
