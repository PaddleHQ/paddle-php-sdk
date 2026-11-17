<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\CheckoutDomain;

use Paddle\SDK\PaddleEnum;

/**
 * @method static CheckoutDomainPaymentMethodVerificationStatus Verified()
 * @method static CheckoutDomainPaymentMethodVerificationStatus Unverified()
 */
final class CheckoutDomainPaymentMethodVerificationStatus extends PaddleEnum
{
    private const Verified = 'verified';
    private const Unverified = 'unverified';
}
