<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Collections;

use Paddle\SDK\Entities\SubscriptionWithIncludes;

class SubscriptionWithIncludesCollection extends Collection
{
    public static function from(array $itemsData, Paginator $paginator = null): self
    {
        return new self(
            array_map(fn (array $item): SubscriptionWithIncludes => SubscriptionWithIncludes::from($item), $itemsData),
            $paginator,
        );
    }

    public function current(): SubscriptionWithIncludes
    {
        return parent::current();
    }
}
