<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Metrics\Operations;

use Paddle\SDK\HasParameters;

class GetMetrics implements HasParameters
{
    private const DATE_FORMAT = '/^\d{4}-\d{2}-\d{2}$/';

    public function __construct(
        private readonly string $from,
        private readonly string $to,
    ) {
        self::validateDate($from, 'from');
        self::validateDate($to, 'to');
    }

    public function getParameters(): array
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
        ];
    }

    private static function validateDate(string $value, string $field): void
    {
        if (preg_match(self::DATE_FORMAT, $value) !== 1) {
            throw new \InvalidArgumentException(sprintf("'%s' must be a date string in YYYY-MM-DD format, got '%s'", $field, $value));
        }

        $parsed = \DateTimeImmutable::createFromFormat('Y-m-d', $value);
        if ($parsed === false || $parsed->format('Y-m-d') !== $value) {
            throw new \InvalidArgumentException(sprintf("'%s' must be a valid date in YYYY-MM-DD format, got '%s'", $field, $value));
        }
    }
}
