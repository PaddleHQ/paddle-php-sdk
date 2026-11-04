<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Metrics;

use Paddle\SDK\Entities\Shared\Pagination;

class MetricsExplorePagination
{
    private function __construct(
        public int $perPage,
        public string $next,
        public bool $hasMore,
        public int $estimatedTotal,
        // Explore pages by re-POSTing to `next`, which the SDK can't target, so pass this to explore() instead.
        public string|null $after,
    ) {
    }

    public static function from(Pagination $pagination): self
    {
        return new self(
            perPage: $pagination->perPage,
            next: $pagination->next,
            hasMore: $pagination->hasMore,
            estimatedTotal: $pagination->estimatedTotal,
            after: self::after($pagination),
        );
    }

    private static function after(Pagination $pagination): string|null
    {
        if ($pagination->next === '') {
            return null;
        }

        $query = parse_url($pagination->next, PHP_URL_QUERY);
        if (! is_string($query)) {
            return null;
        }

        parse_str($query, $parameters);
        $after = $parameters['after'] ?? null;

        return is_string($after) && $after !== '' ? $after : null;
    }
}
