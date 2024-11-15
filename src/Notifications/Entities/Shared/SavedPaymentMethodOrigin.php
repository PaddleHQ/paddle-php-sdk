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
 * @method static SavedPaymentMethodOrigin SavedDuringPurchase()
 * @method static SavedPaymentMethodOrigin Subscription()
 */
final class SavedPaymentMethodOrigin extends PaddleEnum
{
    private const SavedDuringPurchase = 'saved_during_purchase';
    private const Subscription = 'subscription';
}
