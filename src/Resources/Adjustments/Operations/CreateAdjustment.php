<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Adjustments\Operations;

use Paddle\SDK\Entities\Adjustment\AdjustmentType;
use Paddle\SDK\Entities\Shared\Action;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Adjustments\Operations\Create\AdjustmentItem;
use Paddle\SDK\Undefined;

class CreateAdjustment implements \JsonSerializable
{
    use FiltersUndefined;

    /**
     * @param array<AdjustmentItem> $items
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        public readonly Action $action,
        public readonly array|Undefined $items,
        public readonly string $reason,
        public readonly string $transactionId,
        public readonly AdjustmentType|Undefined $type = new Undefined(),
    ) {
        if ($this->type === AdjustmentType::Partial() && ($this->items instanceof Undefined || empty($this->items))) {
            throw InvalidArgumentException::arrayIsEmpty('items');
        }
    }

    public function jsonSerialize(): array
    {
        $items = [];

        if (! $this->items instanceof Undefined) {
            foreach ($this->items as $item) {
                $items[] = [
                    'item_id' => $item->itemId,
                    'type' => $item->type->getValue(),
                    'amount' => $item->amount,
                ];
            }
        }

        return $this->filterUndefined([
            'action' => $this->action,
            'items' => $items,
            'reason' => $this->reason,
            'transaction_id' => $this->transactionId,
            'type' => $this->type,
        ]);
    }
}
