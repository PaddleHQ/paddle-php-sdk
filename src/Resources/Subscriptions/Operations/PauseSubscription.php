<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Subscription\SubscriptionEffectiveFrom;
use Paddle\SDK\Entities\Subscription\SubscriptionOnResume;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class PauseSubscription implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly SubscriptionEffectiveFrom|null $effectiveFrom = null,
        public readonly \DateTimeInterface|null $resumeAt = null,
        public readonly SubscriptionOnResume|Undefined $onResume = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'effective_from' => $this->effectiveFrom,
            'resume_at' => isset($this->resumeAt) ? DateTime::from($this->resumeAt)?->format() : null,
            'on_resume' => $this->onResume,
        ]);
    }
}
