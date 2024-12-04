<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\CustomerPortalSession;

use Paddle\SDK\Notifications\Entities\Entity;

class CustomerPortalSessionSubscriptionUrl implements Entity
{
    private function __construct(
        public string $id,
        public string $cancelSubscription,
        public string $updateSubscriptionPaymentMethod,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            cancelSubscription: $data['cancel_subscription'],
            updateSubscriptionPaymentMethod: $data['update_subscription_payment_method'],
        );
    }
}
