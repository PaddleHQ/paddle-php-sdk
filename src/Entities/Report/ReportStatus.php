<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Report;

use Paddle\SDK\PaddleEnum;

/**
 * @method static ReportStatus Pending()
 * @method static ReportStatus Ready()
 * @method static ReportStatus Failed()
 * @method static ReportStatus Expired()
 */
final class ReportStatus extends PaddleEnum
{
    private const Pending = 'pending';
    private const Ready = 'ready';
    private const Failed = 'failed';
    private const Expired = 'expired';
}
