<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Simulation\Config\Option;

use Paddle\SDK\PaddleEnum;

/**
 * @method static PaymentOutcome Success()
 * @method static PaymentOutcome RecoveredExistingPaymentMethod()
 * @method static PaymentOutcome RecoveredUpdatedPaymentMethod()
 * @method static PaymentOutcome Failed()
 */
final class PaymentOutcome extends PaddleEnum
{
    private const Success = 'success';
    private const RecoveredExistingPaymentMethod = 'recovered_existing_payment_method';
    private const RecoveredUpdatedPaymentMethod = 'recovered_updated_payment_method';
    private const Failed = 'failed';
}
