<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\Update;

class TransactionUpdateItem
{
    public function __construct(
        public string $priceId,
        public int $quantity,
    ) {
    }
}
