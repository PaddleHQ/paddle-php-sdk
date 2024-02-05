<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Report;

class ReportFilter
{
    public function __construct(
        public ReportFilterName $name,
        public ReportFilterOperator|null $operator,
        public array|string $value,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            name: ReportFilterName::from($data['name']),
            operator: isset($data['operator']) ? ReportFilterOperator::from($data['operator']) : null,
            value: $data['value'],
        );
    }
}
