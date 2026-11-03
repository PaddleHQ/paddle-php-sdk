<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Settings;

use Paddle\SDK\Entities\Entity;

class TaxSettings implements Entity
{
    private function __construct(
        public DefaultTaxMode $defaultTaxMode,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            defaultTaxMode: DefaultTaxMode::from($data['default_tax_mode']),
        );
    }
}
