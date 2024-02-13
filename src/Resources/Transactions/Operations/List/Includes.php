<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations\List;

use Paddle\SDK\PaddleEnum;

/**
 * @method static Includes Address()
 * @method static Includes Adjustment()
 * @method static Includes AdjustmentsTotals()
 * @method static Includes AvailablePaymentMethods()
 * @method static Includes Business()
 * @method static Includes Customer()
 * @method static Includes Discount()
 */
class Includes extends PaddleEnum
{
    public const Address = 'address';
    public const Adjustment = 'adjustment';
    public const AdjustmentsTotals = 'adjustments_totals';
    public const AvailablePaymentMethods = 'available_payment_methods';
    public const Business = 'business';
    public const Customer = 'customer';
    public const Discount = 'discount';
}
