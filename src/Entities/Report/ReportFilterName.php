<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Report;

enum ReportFilterName: string
{
    case CollectionMode = 'collection_mode';
    case CurrencyCode = 'currency_code';
    case Origin = 'origin';
    case Status = 'status';
    case UpdatedAt = 'updated_at';
}
