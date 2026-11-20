<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Verification\VerificationStatus;
use Paddle\SDK\Entities\Verification\VerificationType;

class Verification implements Entity
{
    /**
     * @param array<VerificationStep> $steps
     */
    private function __construct(
        public string $id,
        public VerificationStatus $status,
        public VerificationType $verificationType,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
        public array $steps,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            status: VerificationStatus::from($data['status']),
            verificationType: VerificationType::from($data['verification_type']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
            steps: array_map(
                fn (array $step): VerificationStep => VerificationStep::from($step),
                $data['steps'],
            ),
        );
    }
}
