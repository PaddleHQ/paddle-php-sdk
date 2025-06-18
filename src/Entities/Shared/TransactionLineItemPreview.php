<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\Entities\Product;
use Paddle\SDK\Entities\Transaction\TransactionPreviewProduct;
use Paddle\SDK\Entities\Transaction\TransactionProration;

class TransactionLineItemPreview
{
    private function __construct(
        public string|null $priceId,
        public int $quantity,
        public string $taxRate,
        public UnitTotals $unitTotals,
        public Totals $totals,
        public Product|TransactionPreviewProduct $product,
        public TransactionProration|null $proration,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['price_id'] ?? null,
            $data['quantity'],
            $data['tax_rate'],
            UnitTotals::from($data['unit_totals']),
            Totals::from($data['totals']),
            isset($data['product']['id'])
                ? Product::from($data['product'])
                : TransactionPreviewProduct::from($data['product']),
            isset($data['proration']) ? TransactionProration::from($data['proration']) : null,
        );
    }
}
