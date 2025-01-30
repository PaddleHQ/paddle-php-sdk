<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\Payout\PayoutStatus;
use Paddle\SDK\Notifications\Entities\Shared\CurrencyCodePayouts;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

final class Payout implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly PayoutStatus|Undefined $status = new Undefined(),
        public readonly string|Undefined $amount = new Undefined(),
        public readonly CurrencyCodePayouts|Undefined $currencyCode = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            status: self::optional($data, 'status', fn ($value) => PayoutStatus::from($value)),
            amount: self::optional($data, 'amount'),
            currencyCode: self::optional($data, 'currency_code', fn ($value) => CurrencyCodePayouts::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'status' => $this->status,
            'amount' => $this->amount,
            'currency_code' => $this->currencyCode,
        ]);
    }
}
