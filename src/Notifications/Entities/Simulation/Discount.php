<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Discount\DiscountStatus;
use Paddle\SDK\Notifications\Entities\Discount\DiscountType;
use Paddle\SDK\Notifications\Entities\Shared\CurrencyCode;
use Paddle\SDK\Notifications\Entities\Shared\CustomData;
use Paddle\SDK\Notifications\Entities\Shared\ImportMeta;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

final class Discount implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly DiscountStatus|Undefined $status = new Undefined(),
        public readonly string|Undefined $description = new Undefined(),
        public readonly bool|Undefined $enabledForCheckout = new Undefined(),
        public readonly string|Undefined|null $code = new Undefined(),
        public readonly DiscountType|Undefined $type = new Undefined(),
        public readonly string|Undefined $amount = new Undefined(),
        public readonly CurrencyCode|Undefined|null $currencyCode = new Undefined(),
        public readonly bool|Undefined $recur = new Undefined(),
        public readonly int|Undefined|null $maximumRecurringIntervals = new Undefined(),
        public readonly int|Undefined|null $usageLimit = new Undefined(),
        public readonly array|Undefined|null $restrictTo = new Undefined(),
        public readonly CustomData|Undefined|null $customData = new Undefined(),
        public readonly ImportMeta|Undefined|null $importMeta = new Undefined(),
        public readonly \DateTimeInterface|Undefined|null $expiresAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined $createdAt = new Undefined(),
        public readonly \DateTimeInterface|Undefined $updatedAt = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            status: self::optional($data, 'status', fn ($value) => DiscountStatus::from($value)),
            description: self::optional($data, 'description'),
            enabledForCheckout: self::optional($data, 'enabled_for_checkout'),
            code: self::optional($data, 'code'),
            type: self::optional($data, 'type', fn ($value) => DiscountType::from($value)),
            amount: self::optional($data, 'amount'),
            currencyCode: self::optional($data, 'currency_code', fn ($value) => CurrencyCode::from($value)),
            recur: self::optional($data, 'recur'),
            maximumRecurringIntervals: self::optional($data, 'maximum_recurring_intervals'),
            usageLimit: self::optional($data, 'usage_limit'),
            restrictTo: self::optional($data, 'restrict_to'),
            customData: self::optional($data, 'custom_data', fn ($value) => new CustomData($value)),
            importMeta: self::optional($data, 'import_meta', fn ($value) => ImportMeta::from($value)),
            expiresAt: self::optional($data, 'expires_at', fn ($value) => DateTime::from($value)),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
            updatedAt: self::optional($data, 'updated_at', fn ($value) => DateTime::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'status' => $this->status,
            'description' => $this->description,
            'enabled_for_checkout' => $this->enabledForCheckout,
            'code' => $this->code,
            'type' => $this->type,
            'amount' => $this->amount,
            'currency_code' => $this->currencyCode,
            'recur' => $this->recur,
            'maximum_recurring_intervals' => $this->maximumRecurringIntervals,
            'usage_limit' => $this->usageLimit,
            'restrict_to' => $this->restrictTo,
            'custom_data' => $this->customData,
            'import_meta' => $this->importMeta,
            'expires_at' => $this->expiresAt,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ]);
    }
}
