<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Discounts\Operations;

use Paddle\SDK\Entities\Discount\DiscountStatus;
use Paddle\SDK\Entities\Discount\DiscountType;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateDiscount implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<string>|null $restrictTo
     */
    public function __construct(
        public readonly string|Undefined $amount = new Undefined(),
        public readonly string|Undefined $description = new Undefined(),
        public readonly DiscountType|Undefined $type = new Undefined(),
        public readonly bool|Undefined $enabledForCheckout = new Undefined(),
        public readonly bool|Undefined $recur = new Undefined(),
        public readonly CurrencyCode|Undefined $currencyCode = new Undefined(),
        public readonly string|Undefined|null $code = new Undefined(),
        public readonly int|Undefined|null $maximumRecurringIntervals = new Undefined(),
        public readonly int|Undefined|null $usageLimit = new Undefined(),
        public readonly array|Undefined|null $restrictTo = new Undefined(),
        public readonly string|Undefined|null $expiresAt = new Undefined(),
        public readonly DiscountStatus|Undefined $status = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
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
            'status' => $this->status,
            'custom_data' => $this->customData,
        ]);
    }
}
