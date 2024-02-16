<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

interface Entity
{
    /**
     * A static factory for the entity that confirms to the Paddle API.
     */
    public static function from(array $data): self;
}
