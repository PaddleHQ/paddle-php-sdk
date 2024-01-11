<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Report;

class ReportFilters
{
    public function __construct(
        public ReportName $name,
        public ReportOperator|null $operator,
        public array|string $value,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            name: ReportName::from($data['name']),
            operator: isset($data['operator']) ? ReportOperator::from($data['operator']) : null,
            value: $data['value'],
        );
    }
}
