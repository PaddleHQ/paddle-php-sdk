<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\CustomerPortalSessions\Operations;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class CreateCustomerPortalSession implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param string[] $subscriptionIds
     */
    public function __construct(
        public readonly array|Undefined $subscriptionIds = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'subscription_ids' => $this->subscriptionIds,
        ]);
    }
}
