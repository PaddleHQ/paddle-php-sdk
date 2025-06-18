<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\Preview;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class TransactionItemPreviewWithPriceId implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public string $priceId,
        public int $quantity,
        public bool|Undefined $includeInTotals = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'price_id' => $this->priceId,
            'quantity' => $this->quantity,
            'include_in_totals' => $this->includeInTotals,
        ]);
    }
}
