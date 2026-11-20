<?php

declare(strict_types=1);

namespace Paddle\SDK;

use MyCLabs\Enum\Enum;

/**
 * @method static static Undefined()
 */
class PaddleEnum extends Enum
{
    protected const Undefined = null;

    /**
     * Unlike MyCLabs enums, unknown API values are assigned after construction.
     *
     * @phpstan-readonly-allow-private-mutation
     */
    protected $value;

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
