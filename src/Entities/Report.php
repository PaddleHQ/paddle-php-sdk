<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\Report\ReportFilter;
use Paddle\SDK\Entities\Report\ReportStatus;
use Paddle\SDK\Entities\Report\ReportType;

class Report implements Entity
{
    /**
     * @param array<ReportFilter> $filters
     */
    private function __construct(
        public string $id,
        public ReportStatus $status,
        public int|null $rows,
        public ReportType $type,
        public array $filters,
        public \DateTimeInterface|null $expiresAt,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            status: ReportStatus::from($data['status']),
            rows: $data['rows'] ?? null,
            type: ReportType::from($data['type']),
            filters: array_map(fn (array $filter): ReportFilter => ReportFilter::from($filter), $data['filters'] ?? []),
            expiresAt: isset($data['expires_at']) ? DateTime::from($data['expires_at']) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
