<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Notifications\Entities\ApiKeyExposure\ApiKeyExposureActionTaken;
use Paddle\SDK\Notifications\Entities\ApiKeyExposure\ApiKeyExposureRiskLevel;
use Paddle\SDK\Notifications\Entities\ApiKeyExposure\ApiKeyExposureSource;
use Paddle\SDK\Notifications\Entities\DateTime;
use Paddle\SDK\Notifications\Entities\Simulation\Traits\OptionalProperties;
use Paddle\SDK\Undefined;

final class ApiKeyExposure implements SimulationEntity
{
    use OptionalProperties;
    use FiltersUndefined;

    public function __construct(
        public readonly string|Undefined $id = new Undefined(),
        public readonly string|Undefined $apiKeyId = new Undefined(),
        public readonly ApiKeyExposureRiskLevel|Undefined $riskLevel = new Undefined(),
        public readonly ApiKeyExposureActionTaken|Undefined $actionTaken = new Undefined(),
        public readonly ApiKeyExposureSource|Undefined $source = new Undefined(),
        public readonly string|Undefined $reference = new Undefined(),
        public readonly string|Undefined|null $description = new Undefined(),
        public readonly \DateTimeInterface|Undefined $createdAt = new Undefined(),
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: self::optional($data, 'id'),
            apiKeyId: self::optional($data, 'api_key_id'),
            riskLevel: self::optional($data, 'risk_level', fn ($value) => ApiKeyExposureRiskLevel::from($value)),
            actionTaken: self::optional($data, 'action_taken', fn ($value) => ApiKeyExposureActionTaken::from($value)),
            source: self::optional($data, 'source', fn ($value) => ApiKeyExposureSource::from($value)),
            reference: self::optional($data, 'reference'),
            description: self::optional($data, 'description'),
            createdAt: self::optional($data, 'created_at', fn ($value) => DateTime::from($value)),
        );
    }

    public function jsonSerialize(): mixed
    {
        return $this->filterUndefined([
            'id' => $this->id,
            'api_key_id' => $this->apiKeyId,
            'risk_level' => $this->riskLevel,
            'action_taken' => $this->actionTaken,
            'source' => $this->source,
            'reference' => $this->reference,
            'description' => $this->description,
            'created_at' => $this->createdAt,
        ]);
    }
}
