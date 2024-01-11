<?php

declare(strict_types=1);

namespace Paddle\SDK;

trait FiltersUndefined
{
    /**
     * @param array<mixed> $values
     */
    public function filterUndefined(array $values): array
    {
        return array_filter($values, fn ($value): bool => ! is_a($value, Undefined::class));
    }
}
