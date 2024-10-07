<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\Preview;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Transactions\Operations\Price\TransactionNonCatalogPrice;
use Paddle\SDK\Resources\Transactions\Operations\Price\TransactionNonCatalogPriceWithProduct;
use Paddle\SDK\Undefined;

class TransactionItemPreviewWithNonCatalogPrice implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public TransactionNonCatalogPrice|TransactionNonCatalogPriceWithProduct $price,
        public int $quantity,
        public bool|Undefined $includeInTotals = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'price' => $this->price,
            'quantity' => $this->quantity,
            'include_in_totals' => $this->includeInTotals,
        ]);
    }
}
