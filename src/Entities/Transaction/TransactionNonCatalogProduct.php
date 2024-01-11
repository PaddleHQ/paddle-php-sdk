<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\TaxCategory;

class TransactionNonCatalogProduct
{
    public function __construct(
        public string $name,
        public string|null $description,
        public TaxCategory $taxCategory,
        public null|string $imageUrl,
        public CustomData|null $customData,
    ) {
    }
}
