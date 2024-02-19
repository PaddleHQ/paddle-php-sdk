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
 * @method static PaymentMethodType Alipay()
 * @method static PaymentMethodType ApplePay()
 * @method static PaymentMethodType Bancontact()
 * @method static PaymentMethodType Card()
 * @method static PaymentMethodType GooglePay()
 * @method static PaymentMethodType Ideal()
 * @method static PaymentMethodType Offline()
 * @method static PaymentMethodType Paypal()
 * @method static PaymentMethodType Unknown()
 * @method static PaymentMethodType WireTransfer()
 */
final class PaymentMethodType extends PaddleEnum
{
    private const Alipay = 'alipay';
    private const ApplePay = 'apple_pay';
    private const Bancontact = 'bancontact';
    private const Card = 'card';
    private const GooglePay = 'google_pay';
    private const Ideal = 'ideal';
    private const Offline = 'offline';
    private const Paypal = 'paypal';
    private const Unknown = 'unknown';
    private const WireTransfer = 'wire_transfer';
}
