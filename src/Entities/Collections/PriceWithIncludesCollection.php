<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Collections;

use Paddle\SDK\Entities\PriceWithIncludes;

class PriceWithIncludesCollection extends Collection
{
    public static function from(array $itemsData, Paginator $paginator = null): self
    {
        return new self(
            array_map(fn (array $item): PriceWithIncludes => PriceWithIncludes::from($item), $itemsData),
            $paginator,
        );
    }

    public function current(): PriceWithIncludes
    {
        return parent::current();
    }
}
