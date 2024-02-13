<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations\Get;

use Paddle\SDK\PaddleEnum;

/**
 * @method static Includes NextTransaction()
 * @method static Includes RecurringTransactionDetails()
 */
class Includes extends PaddleEnum
{
    public const NextTransaction = 'next_transaction';
    public const RecurringTransactionDetails = 'recurring_transaction_details';
}
