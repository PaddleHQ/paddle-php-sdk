<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

use Paddle\SDK\Entities\Shared\Pagination;

class MetricsExploreResponse
{
    public function __construct(
        public MetricsExploreData $data,
        public Pagination $pagination,
    ) {
    }

    public function hasMore(): bool
    {
        return $this->pagination->hasMore;
    }

    /**
     * The `after` cursor to pass to the next runExploreQuery() call, or null on the last page.
     */
    public function nextCursor(): string|null
    {
        if (! $this->hasMore() || $this->pagination->next === '') {
            return null;
        }

        $query = parse_url($this->pagination->next, PHP_URL_QUERY);
        if (! is_string($query)) {
            return null;
        }

        parse_str($query, $parameters);
        $after = $parameters['after'] ?? null;

        return is_string($after) && $after !== '' ? $after : null;
    }
}
