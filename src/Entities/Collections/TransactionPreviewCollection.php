<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Collections;

use Paddle\SDK\Entities\TransactionPreview;

class TransactionPreviewCollection extends Collection
{
    public static function from(array $itemsData, Paginator|null $paginator = null): self
    {
        return new self(
            array_map(fn (array $item): TransactionPreview => TransactionPreview::from($item), $itemsData),
            $paginator,
        );
    }

    public function current(): TransactionPreview
    {
        return parent::current();
    }
}
