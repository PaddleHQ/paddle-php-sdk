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

class SubscriptionConsentRequirement
{
    private function __construct(
        public string $id,
        public SubscriptionConsentRequirementType $requirement,
        public SubscriptionConsentRequirementStatus $status,
        public \DateTimeInterface $createdAt,
        public SubscriptionTimePeriod|null $consentPeriod,
        public \DateTimeInterface|null $grantedAt,
        public \DateTimeInterface|null $voidedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['id'],
            SubscriptionConsentRequirementType::from($data['requirement']),
            SubscriptionConsentRequirementStatus::from($data['status']),
            DateTime::from($data['created_at']),
            isset($data['consent_period']) ? SubscriptionTimePeriod::from($data['consent_period']) : null,
            isset($data['granted_at']) ? DateTime::from($data['granted_at']) : null,
            isset($data['voided_at']) ? DateTime::from($data['voided_at']) : null,
        );
    }
}
