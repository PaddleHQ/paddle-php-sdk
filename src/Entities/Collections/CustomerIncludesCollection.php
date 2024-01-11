<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Collections;

use Paddle\SDK\Entities\CustomerIncludes;

class CustomerIncludesCollection extends Collection
{
    public static function from(array $itemsData, Paginator $paginator = null): self
    {
        return new self(
            array_map(fn (array $item): CustomerIncludes => CustomerIncludes::from($item), $itemsData),
            $paginator,
        );
    }

    public function current(): CustomerIncludes
    {
        return parent::current();
    }
}
