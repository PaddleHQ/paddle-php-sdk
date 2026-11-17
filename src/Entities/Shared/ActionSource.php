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
 * @method static ActionSource System()
 * @method static ActionSource Api()
 * @method static ActionSource Dashboard()
 * @method static ActionSource CustomerPortal()
 * @method static ActionSource SupportBot()
 * @method static ActionSource Retain()
 * @method static ActionSource Checkout()
 * @method static ActionSource ExternalProvider()
 * @method static ActionSource PaddleClassic()
 * @method static ActionSource Unknown()
 */
final class ActionSource extends PaddleEnum
{
    private const System = 'system';
    private const Api = 'api';
    private const Dashboard = 'dashboard';
    private const CustomerPortal = 'customer_portal';
    private const SupportBot = 'support_bot';
    private const Retain = 'retain';
    private const Checkout = 'checkout';
    private const ExternalProvider = 'external_provider';
    private const PaddleClassic = 'paddle_classic';
    private const Unknown = 'unknown';
}
