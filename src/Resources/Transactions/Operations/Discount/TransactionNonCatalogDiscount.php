<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\Discount;

use Paddle\SDK\Entities\Discount\DiscountType;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class TransactionNonCatalogDiscount implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<string>|null $restrictTo
     */
    public function __construct(
        public readonly string $amount,
        public readonly string $description,
        public readonly DiscountType $type,
        public readonly bool|Undefined $recur = new Undefined(),
        public readonly int|Undefined|null $maximumRecurringIntervals = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly array|Undefined|null $restrictTo = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'amount' => $this->amount,
            'description' => $this->description,
            'type' => $this->type,
            'recur' => $this->recur,
            'maximum_recurring_intervals' => $this->maximumRecurringIntervals,
            'custom_data' => $this->customData,
            'restrict_to' => $this->restrictTo,
        ]);
    }
}
