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
 * @method static AvailablePaymentMethods Blik()
 * @method static AvailablePaymentMethods Card()
 * @method static AvailablePaymentMethods GooglePay()
 * @method static AvailablePaymentMethods Ideal()
 * @method static AvailablePaymentMethods MbWay()
 * @method static AvailablePaymentMethods Offline()
 * @method static AvailablePaymentMethods Paypal()
 * @method static AvailablePaymentMethods Pix()
 * @method static AvailablePaymentMethods Unknown()
 * @method static AvailablePaymentMethods Upi()
 * @method static AvailablePaymentMethods WireTransfer()
 */
final class AvailablePaymentMethods extends PaddleEnum
{
    private const Alipay = 'alipay';
    private const ApplePay = 'apple_pay';
    private const Bancontact = 'bancontact';
    private const Blik = 'blik';
    private const Card = 'card';
    private const GooglePay = 'google_pay';
    private const Ideal = 'ideal';
    private const MbWay = 'mb_way';
    private const Offline = 'offline';
    private const Paypal = 'paypal';
    private const Pix = 'pix';
    private const Unknown = 'unknown';
    private const Upi = 'upi';
    private const WireTransfer = 'wire_transfer';
}
