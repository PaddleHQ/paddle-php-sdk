<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateCheckoutStylesOverlay implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined|null $primaryCheckoutColor = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'primary_checkout_color' => $this->primaryCheckoutColor,
        ]);
    }
}
