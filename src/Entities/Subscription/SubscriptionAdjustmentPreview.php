<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Subscription;

use Paddle\SDK\Entities\Shared\TotalAdjustments;

class SubscriptionAdjustmentPreview
{
    /**
     * @param array<SubscriptionAdjustmentItem> $items
     */
    public function __construct(
        public string $transactionId,
        public array $items,
        public TotalAdjustments $totals,
    ) {
    }
}
