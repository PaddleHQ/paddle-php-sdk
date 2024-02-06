<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Collections;

use Paddle\SDK\Entities\Notification;

class NotificationCollection extends Collection
{
    public static function from(array $itemsData, Paginator|null $paginator = null): self
    {
        return new self(
            array_map(fn (array $item): Notification => Notification::from($item), $itemsData),
            $paginator,
        );
    }

    public function current(): Notification
    {
        return parent::current();
    }
}
