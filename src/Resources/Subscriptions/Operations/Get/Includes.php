<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Subscriptions\Operations\Get;

enum Includes: string
{
    case NextTransaction = 'next_transaction';
    case RecurringTransactionDetails = 'recurring_transaction_details';
}
