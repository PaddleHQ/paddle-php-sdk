<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities;

use Paddle\SDK\Notifications\Entities\Discount\DiscountStatus;
use Paddle\SDK\Notifications\Entities\Discount\DiscountType;
use Paddle\SDK\Notifications\Entities\Shared\CurrencyCode;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;

class Discount implements Entity
{
    private function __construct(
        public string $id,
        public DiscountStatus $status,
        public string $description,
        public bool $enabledForCheckout,
        public string|null $code,
        public DiscountType $type,
        public string $amount,
        public CurrencyCode|null $currencyCode,
        public bool $recur,
        public int|null $maximumRecurringIntervals,
        public int|null $usageLimit,
        public array|null $restrictTo,
        public CustomData|null $customData,
        public ImportMeta|null $importMeta,
        public \DateTimeInterface|null $expiresAt,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            status: DiscountStatus::from($data['status']),
            description: $data['description'],
            enabledForCheckout: $data['enabled_for_checkout'],
            code: $data['code'] ?? null,
            type: DiscountType::from($data['type']),
            amount: $data['amount'],
            currencyCode: $data['currency_code'] ? CurrencyCode::from($data['currency_code']) : null,
            recur: $data['recur'],
            maximumRecurringIntervals: $data['maximum_recurring_intervals'],
            usageLimit: $data['usage_limit'] ?? null,
            restrictTo: $data['restrict_to'] ?? null,
            customData: isset($data['custom_data']) ? new CustomData($data['custom_data']) : null,
            importMeta: isset($data['import_meta']) ? ImportMeta::from($data['import_meta']) : null,
            expiresAt: isset($data['expires_at']) ? DateTime::from($data['expires_at']) : null,
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
