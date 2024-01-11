<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\PricingPreview;

use Paddle\SDK\Entities\Entity;

class PricePreviewDetails implements Entity
{
    /**
     * @param array<PricePreviewLineItem> $lineItems
     */
    public function __construct(
        public array $lineItems,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            array_map(fn ($item): PricePreviewLineItem => PricePreviewLineItem::from($item), $data['line_items']),
        );
    }
}
