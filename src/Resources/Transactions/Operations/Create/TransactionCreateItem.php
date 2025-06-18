<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\Create;

class TransactionCreateItem
{
    public function __construct(
        public string $priceId,
        public int $quantity,
    ) {
    }
}
