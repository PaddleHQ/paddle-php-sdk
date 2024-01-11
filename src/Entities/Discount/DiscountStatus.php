<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Discount;

enum DiscountStatus: string
{
    case Active = 'active';
    case Archived = 'archived';
    case Expired = 'expired';
    case Used = 'used';
}
