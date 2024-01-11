<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Shared\Operations\List;

enum Comparator: string
{
    case LT = 'LT';
    case LTE = 'LTE';
    case GT = 'GT';
    case GTE = 'GTE';
}
