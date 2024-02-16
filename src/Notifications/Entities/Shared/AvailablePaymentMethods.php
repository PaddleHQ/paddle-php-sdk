<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

use Paddle\SDK\PaddleEnum;

/**
 * @method static AvailablePaymentMethods Alipay()
 * @method static AvailablePaymentMethods ApplePay()
 * @method static AvailablePaymentMethods Bancontact()
 * @method static AvailablePaymentMethods Card()
 * @method static AvailablePaymentMethods GooglePay()
 * @method static AvailablePaymentMethods Ideal()
 * @method static AvailablePaymentMethods Paypal()
 */
final class AvailablePaymentMethods extends PaddleEnum
{
    private const Alipay = 'alipay';
    private const ApplePay = 'apple_pay';
    private const Bancontact = 'bancontact';
    private const Card = 'card';
    private const GooglePay = 'google_pay';
    private const Ideal = 'ideal';
    private const Paypal = 'paypal';
}
