<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation\Traits;

use Paddle\SDK\Undefined;

trait OptionalProperties
{
    /**
     * @return mixed|Undefined value for provided key when set, otherwise undefined
     */
    private static function optional(array $data, string $key, \Closure|null $callback = null): mixed
    {
        if (array_key_exists($key, $data)) {
            $value = $data[$key];

            return $callback && $value !== null ? $callback($value) : $value;
        }

        return new Undefined();
    }

    /**
     * @return array|Undefined|null values for provided key when set, otherwise undefined
     */
    private static function optionalList(array $data, string $key, \Closure|null $callback = null): array|Undefined|null
    {
        return self::optional(
            $data,
            $key,
            fn ($items) => array_map(fn (array $item) => $callback($item), $items),
        );
    }
}
