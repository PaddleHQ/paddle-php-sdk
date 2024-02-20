<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\PaddleEnum;

/**
 * @method static TransactionStatus Draft()
 * @method static TransactionStatus Ready()
 * @method static TransactionStatus Billed()
 * @method static TransactionStatus Paid()
 * @method static TransactionStatus Completed()
 * @method static TransactionStatus Canceled()
 * @method static TransactionStatus PastDue()
 */
final class TransactionStatus extends PaddleEnum
{
    private const Draft = 'draft';
    private const Ready = 'ready';
    private const Billed = 'billed';
    private const Paid = 'paid';
    private const Completed = 'completed';
    private const Canceled = 'canceled';
    private const PastDue = 'past_due';
}
