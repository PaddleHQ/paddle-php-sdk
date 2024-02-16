<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\Entities\DateTime;

class SubscriptionScheduledChange
{
    private function __construct(
        public SubscriptionScheduledChangeAction $action,
        public \DateTimeInterface $effectiveAt,
        public \DateTimeInterface|null $resumeAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            SubscriptionScheduledChangeAction::from($data['action']),
            DateTime::from($data['effective_at']),
            isset($data['resume_at']) ? DateTime::from($data['resume_at']) : null,
        );
    }
}
