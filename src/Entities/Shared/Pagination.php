<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

class Pagination
{
    public function __construct(
        public int $perPage,
        public string $next,
        public bool $hasMore,
        public int $estimatedTotal,
    ) {
    }
}
