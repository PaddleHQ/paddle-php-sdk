<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class SubscriptionCreationItem implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $priceId = new Undefined(),
        public readonly int|Undefined $quantity = new Undefined(),
    ) {
    }

    public function jsonSerialize(): \stdClass
    {
        return (object) $this->filterUndefined([
            'price_id' => $this->priceId,
            'quantity' => $this->quantity,
        ]);
    }
}
