<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\List;

enum Includes: string
{
    case Address = 'address';
    case Adjustment = 'adjustment';
    case AdjustmentsTotals = 'adjustments_totals';
    case Business = 'business';
    case Customer = 'customer';
    case Discount = 'discount';
}
