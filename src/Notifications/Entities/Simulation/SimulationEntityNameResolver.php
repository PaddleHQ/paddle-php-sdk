<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\Notifications\Entities\EntityNameResolver;
use Paddle\SDK\Notifications\Entities\UndefinedEntity;

/**
 * @internal
 */
final class SimulationEntityNameResolver
{
    public static function resolve(string $eventType): string
    {
        return EntityNameResolver::resolve($eventType);
    }

    public static function resolveFqn(string $eventType): string
    {
        $fqn = sprintf('\Paddle\SDK\Notifications\Entities\Simulation\%s', self::resolve($eventType));

        return class_exists($fqn) ? $fqn : UndefinedEntity::class;
    }
}
