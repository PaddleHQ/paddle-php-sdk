<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations;

use Paddle\SDK\Entities\Settings\AudienceOptIn;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateCheckoutFeatures implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly bool|Undefined $discountsEnabled = new Undefined(),
        public readonly AudienceOptIn|Undefined $audienceOptIn = new Undefined(),
        public readonly bool|Undefined $savedPaymentMethodsEnabled = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'discounts_enabled' => $this->discountsEnabled,
            'audience_opt_in' => $this->audienceOptIn,
            'saved_payment_methods_enabled' => $this->savedPaymentMethodsEnabled,
        ]);
    }
}
