<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Report;

enum ReportType: string
{
    case Adjustments = 'adjustments';
    case AdjustmentLineItems = 'adjustment_line_items';
    case Transactions = 'transactions';
    case TransactionLineItems = 'transaction_line_items';
}
