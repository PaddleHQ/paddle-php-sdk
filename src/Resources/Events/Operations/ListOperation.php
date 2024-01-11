<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Events\Operations;

use Paddle\SDK\HasParameters;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

class ListOperation implements HasParameters
{
    public function __construct(private readonly ?Pager $pager = null)
    {
    }

    public function getParameters(): array
    {
        return $this->pager?->getParameters() ?? [];
    }
}
