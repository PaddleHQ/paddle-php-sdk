<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations;

use Paddle\SDK\Entities\Subscription\SubscriptionEffectiveFrom;
use Paddle\SDK\Entities\Subscription\SubscriptionItems;
use Paddle\SDK\Entities\Subscription\SubscriptionItemsWithPrice;
use Paddle\SDK\Entities\Subscription\SubscriptionOnPaymentFailure;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class CreateOneTimeCharge implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<SubscriptionItems|SubscriptionItemsWithPrice> $items
     */
    public function __construct(
        public readonly SubscriptionEffectiveFrom $effectiveFrom,
        public readonly array $items,
        public readonly SubscriptionOnPaymentFailure|Undefined $onPaymentFailure = new Undefined(),
        public readonly string|Undefined $receiptData = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'effective_from' => $this->effectiveFrom,
            'items' => $this->items,
            'on_payment_failure' => $this->onPaymentFailure,
        ]);
    }
}
