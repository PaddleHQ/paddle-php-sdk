<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Shared\Operations\List;

use Paddle\SDK\HasParameters;

class Pager implements HasParameters
{
    public function __construct(private readonly string|null $after = null, private OrderBy|null $orderBy = null, private readonly int $perPage = 50)
    {
        $this->orderBy ??= OrderBy::idAscending();
    }

    public function getParameters(): array
    {
        return array_filter([
            'after' => $this->after,
            'order_by' => (string) $this->orderBy,
            'per_page' => $this->perPage,
        ]);
    }
}
