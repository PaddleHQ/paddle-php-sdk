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
 * @method static SavedPaymentMethodType Alipay()
 * @method static SavedPaymentMethodType ApplePay()
 * @method static SavedPaymentMethodType Blik()
 * @method static SavedPaymentMethodType Card()
 * @method static SavedPaymentMethodType GooglePay()
 * @method static SavedPaymentMethodType KoreaLocal()
 * @method static SavedPaymentMethodType MbWay()
 * @method static SavedPaymentMethodType Paypal()
 * @method static SavedPaymentMethodType Pix()
 * @method static SavedPaymentMethodType Upi()
 */
final class SavedPaymentMethodType extends PaddleEnum
{
    private const Alipay = 'alipay';
    private const ApplePay = 'apple_pay';
    private const Blik = 'blik';
    private const Card = 'card';
    private const GooglePay = 'google_pay';
    private const KoreaLocal = 'korea_local';
    private const Paypal = 'paypal';
    private const Pix = 'pix';
    private const MbWay = 'mb_way';
    private const Upi = 'upi';
}
