<?php

declare(strict_types=1);
// TODO: bad naming?!
/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

use Paddle\SDK\PaddleEnum;

/**
 * @method static Type Alipay()
 * @method static Type ApplePay()
 * @method static Type Bancontact()
 * @method static Type Card()
 * @method static Type GooglePay()
 * @method static Type Ideal()
 * @method static Type Offline()
 * @method static Type Paypal()
 * @method static Type Unknown()
 * @method static Type WireTransfer()
 * @method static Type Visa()
 */
final class Type extends PaddleEnum
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
    private const Visa = 'visa';
}
