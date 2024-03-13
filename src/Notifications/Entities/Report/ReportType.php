<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Report;

use Paddle\SDK\PaddleEnum;

/**
 * @method static ReportType Adjustments()
 * @method static ReportType AdjustmentLineItems()
 * @method static ReportType Discounts()
 * @method static ReportType ProductsPrices()
 * @method static ReportType Transactions()
 * @method static ReportType TransactionLineItems()
 */
final class ReportType extends PaddleEnum
{
    private const Adjustments = 'adjustments';
    private const AdjustmentLineItems = 'adjustment_line_items';
    private const Discounts = 'discounts';
    private const ProductsPrices = 'products_prices';
    private const Transactions = 'transactions';
    private const TransactionLineItems = 'transaction_line_items';
}
