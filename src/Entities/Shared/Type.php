<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

enum Type: string
{
    case Alipay = 'alipay';
    case ApplePay = 'apple_pay';
    case Bancontact = 'bancontact';
    case Card = 'card';
    case GooglePay = 'google_pay';
    case Ideal = 'ideal';
    case Offline = 'offline';
    case Paypal = 'paypal';
    case Unknown = 'unknown';
    case WireTransfer = 'wire_transfer';

    case Visa = 'visa';
}
