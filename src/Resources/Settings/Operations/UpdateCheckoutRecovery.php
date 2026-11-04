<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Settings\Operations\Update\CheckoutRecoveryDiscountUpdate;
use Paddle\SDK\Undefined;

class UpdateCheckoutRecovery implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly bool|Undefined $enabled = new Undefined(),
        public readonly CheckoutRecoveryDiscountUpdate|Undefined|null $discount = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'enabled' => $this->enabled,
            'discount' => $this->discount,
        ]);
    }
}
