<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Collections;

use Paddle\SDK\Entities\TransactionWithIncludes;

class TransactionWithIncludesCollection extends Collection
{
    public static function from(array $itemsData, Paginator $paginator = null): self
    {
        return new self(
            array_map(fn (array $item): TransactionWithIncludes => TransactionWithIncludes::from($item), $itemsData),
            $paginator,
        );
    }

    public function current(): TransactionWithIncludes
    {
        return parent::current();
    }
}
