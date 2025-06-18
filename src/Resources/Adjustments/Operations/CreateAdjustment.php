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
        public readonly array|Undefined|null $items,
        public readonly string $reason,
        public readonly string $transactionId,
        public readonly AdjustmentType|Undefined $type = new Undefined(),
    ) {
        $typeIsFull = AdjustmentType::Full()->equals($this->type);

        if (! $typeIsFull && ($this->items instanceof Undefined || empty($this->items))) {
            throw InvalidArgumentException::arrayIsEmpty('items');
        }

        if ($typeIsFull && is_array($this->items)) {
            throw new InvalidArgumentException('items are not allowed when the adjustment type is full');
        }
    }

    public static function full(Action $action, string $reason, string $transactionId): self
    {
        return new self($action, new Undefined(), $reason, $transactionId, AdjustmentType::Full());
    }

    public static function partial(Action $action, array $items, string $reason, string $transactionId): self
    {
        return new self($action, $items, $reason, $transactionId, AdjustmentType::Partial());
    }

    public function jsonSerialize(): array
    {
        if (is_array($this->items)) {
            $items = [];

            foreach ($this->items as $item) {
                $items[] = [
                    'item_id' => $item->itemId,
                    'type' => $item->type->getValue(),
                    'amount' => $item->amount,
                ];
            }
        } else {
            $items = $this->items;
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
