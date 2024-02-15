<?php

declare(strict_types=1);

namespace Paddle\SDK;

use MyCLabs\Enum\Enum;

class PaddleEnum extends Enum
{
    protected const Undefined = null;

    /**
     * @throws \UnexpectedValueException
     */
    public static function from($value): static
    {
        try {
            return parent::from($value);
        } catch (\UnexpectedValueException $e) {
            if ($value === null) {
                throw $e;
            }
            $enum = self::Undefined();
            $enum->value = $value;

            return $enum;
        }
    }

    public function isKnown(): bool
    {
        return $this->getKey() !== 'Undefined';
    }
}
