<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Adjustments\Operations;

use Paddle\SDK\Entities\Adjustment\AdjustmentItem;
use Paddle\SDK\Entities\Shared\Action;

class CreateAdjustment implements \JsonSerializable
{
    /**
     * @param array<AdjustmentItem> $items
     */
    public function __construct(
        public readonly Action $action,
        public readonly array $items,
        public readonly string $reason,
        public readonly string $transactionId,
    ) {
    }

    public function jsonSerialize(): array
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = [
                'item_id' => $item->itemId,
                'type' => $item->type->value,
                'amount' => $item->amount,
            ];
        }

        return [
            'action' => $this->action,
            'items' => $items,
            'reason' => $this->reason,
            'transaction_id' => $this->transactionId,
        ];
    }
}
