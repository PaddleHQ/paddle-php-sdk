<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Collections;

use Paddle\SDK\Entities\Adjustment;

class AdjustmentCollection extends Collection
{
    public static function from(array $itemsData, Paginator|null $paginator = null): self
    {
        return new self(
            array_map(fn (array $item): Adjustment => Adjustment::from($item), $itemsData),
            $paginator,
        );
    }

    public function current(): Adjustment
    {
        return parent::current();
    }
}
