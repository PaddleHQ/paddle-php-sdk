<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Settings;

use Paddle\SDK\Entities\Entity;

class CheckoutFeatures implements Entity
{
    private function __construct(
        public bool $discountsEnabled,
        public AudienceOptIn $audienceOptIn,
        public bool $savedPaymentMethodsEnabled,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            discountsEnabled: $data['discounts_enabled'],
            audienceOptIn: AudienceOptIn::from($data['audience_opt_in']),
            savedPaymentMethodsEnabled: $data['saved_payment_methods_enabled'],
        );
    }
}
