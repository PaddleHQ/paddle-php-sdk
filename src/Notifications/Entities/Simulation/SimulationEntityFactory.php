<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities\Simulation;

use Paddle\SDK\Entities\EventNameResolver;
use Paddle\SDK\Notifications\Entities\Entity;
use Paddle\SDK\Notifications\Entities\EntityNameResolver;
use Paddle\SDK\Notifications\Entities\UndefinedEntity;

final class SimulationEntityFactory
{
    /**
     * @var array<string,int>
     */
    private static array $constructParameterCounts = [];

    public static function create(string $eventType, array $data): SimulationEntity|Entity
    {
        $entity = self::resolveEntityClass($eventType, count($data));

        return $entity::from($data);
    }

    /**
     * @return class-string<SimulationEntity|Entity>
     */
    private static function resolveEntityClass(string $eventType, int $propertyCount): string
    {
        // Use full notification entities when possible for backward compatibility.
        /** @var class-string<Entity> $notificationEntity */
        $notificationEntity = EntityNameResolver::resolveFqn($eventType);
        if (
            class_exists($notificationEntity)
            && in_array(Entity::class, class_implements($notificationEntity), true)
            && $propertyCount >= self::getConstructParameterCount($notificationEntity)
        ) {
            return $notificationEntity;
        }

        /** @var class-string<SimulationEntity> $entity */
        $entity = SimulationEntityNameResolver::resolveFqn($eventType);
        if ($entity === UndefinedEntity::class) {
            return UndefinedEntity::class;
        }

        if (! class_exists($entity) || ! in_array(SimulationEntity::class, class_implements($entity), true)) {
            $identifier = EventNameResolver::resolve($eventType);

            throw new \UnexpectedValueException("Event type '{$identifier}' cannot be mapped to an object");
        }

        return $entity;
    }

    private static function getConstructParameterCount(string $class): int
    {
        return self::$constructParameterCounts[$class] ??= self::getReflectionConstructParameterCount($class);
    }

    private static function getReflectionConstructParameterCount(string $class): int
    {
        return (new \ReflectionMethod($class, '__construct'))->getNumberOfParameters();
    }
}
