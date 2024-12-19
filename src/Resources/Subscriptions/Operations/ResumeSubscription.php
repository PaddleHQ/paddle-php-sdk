<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations;

use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Subscription\SubscriptionOnResume;
use Paddle\SDK\Entities\Subscription\SubscriptionResumeEffectiveFrom;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class ResumeSubscription implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly SubscriptionResumeEffectiveFrom|\DateTimeInterface|null $effectiveFrom = null,
        public readonly SubscriptionOnResume|Undefined $onResume = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'effective_from' => $this->effectiveFrom instanceof \DateTimeInterface
                ? DateTime::from($this->effectiveFrom)?->format()
                : $this->effectiveFrom,
            'on_resume' => $this->onResume,
        ]);
    }
}
