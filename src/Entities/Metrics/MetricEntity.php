<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Metrics;

use Paddle\SDK\PaddleEnum;

/**
 * @method static MetricEntity TransactionsCompleted()
 * @method static MetricEntity AdjustmentsRefunds()
 * @method static MetricEntity AdjustmentsChargebacks()
 * @method static MetricEntity Checkouts()
 * @method static MetricEntity Subscriptions()
 */
final class MetricEntity extends PaddleEnum
{
    private const TransactionsCompleted = 'transactions.completed';
    private const AdjustmentsRefunds = 'adjustments.refunds';
    private const AdjustmentsChargebacks = 'adjustments.chargebacks';
    private const Checkouts = 'checkouts';
    private const Subscriptions = 'subscriptions';
}
