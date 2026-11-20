<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations;

use Paddle\SDK\Entities\Settings\DefaultTaxMode;
use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class UpdateTaxSettings implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly DefaultTaxMode|Undefined $defaultTaxMode = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'default_tax_mode' => $this->defaultTaxMode,
        ]);
    }
}
