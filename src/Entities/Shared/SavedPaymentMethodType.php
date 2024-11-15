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
 * @method static SavedPaymentMethodType Alipay()
 * @method static SavedPaymentMethodType ApplePay()
 * @method static SavedPaymentMethodType Card()
 * @method static SavedPaymentMethodType GooglePay()
 * @method static SavedPaymentMethodType Paypal()
 */
final class SavedPaymentMethodType extends PaddleEnum
{
    private const Alipay = 'alipay';
    private const ApplePay = 'apple_pay';
    private const Card = 'card';
    private const GooglePay = 'google_pay';
    private const Paypal = 'paypal';
}
