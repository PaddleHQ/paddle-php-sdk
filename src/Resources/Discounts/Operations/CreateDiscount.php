<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Discounts\Operations;

use Paddle\SDK\Entities\Discount\DiscountMode;
use Paddle\SDK\Entities\Discount\DiscountType;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class CreateDiscount implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<string>|null $restrictTo
     */
    public function __construct(
        public readonly string $amount,
        public readonly string $description,
        public readonly DiscountType $type,
        public readonly bool $enabledForCheckout,
        public readonly bool $recur,
        public readonly CurrencyCode $currencyCode,
        public readonly string|Undefined|null $code = new Undefined(),
        public readonly int|Undefined|null $maximumRecurringIntervals = new Undefined(),
        public readonly int|Undefined|null $usageLimit = new Undefined(),
        public readonly array|Undefined|null $restrictTo = new Undefined(),
        public readonly string|Undefined|null $expiresAt = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly DiscountMode|Undefined $mode = new Undefined(),
        public string|Undefined|null $discountGroupId = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'amount' => $this->amount,
            'description' => $this->description,
            'type' => $this->type,
            'enabled_for_checkout' => $this->enabledForCheckout,
            'code' => $this->code,
            'currency_code' => $this->currencyCode,
            'recur' => $this->recur,
            'maximum_recurring_intervals' => $this->maximumRecurringIntervals,
            'usage_limit' => $this->usageLimit,
            'restrict_to' => $this->restrictTo,
            'expires_at' => $this->expiresAt,
            'custom_data' => $this->customData,
            'mode' => $this->mode,
            'discount_group_id' => $this->discountGroupId,
        ]);
    }
}
