<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Subscription;

class SubscriptionManagementUrls
{
    private function __construct(
        public string|null $updatePaymentMethod,
        public string $cancel,
    ) {
    }

    public static function from(array $data): self
    {
        return new self($data['update_payment_method'], $data['cancel']);
    }
}
