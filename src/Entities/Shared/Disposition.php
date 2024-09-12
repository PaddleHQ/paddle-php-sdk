<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\PaddleEnum;

/**
 * @method static Disposition Attachment()
 * @method static Disposition Inline()
 */
final class Disposition extends PaddleEnum
{
    private const Attachment = 'attachment';
    private const Inline = 'inline';
}
