<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities;

class EntityFactory
{
    public static function create(string $eventType, array $data): Entity
    {
        $type = explode('.', $eventType);
        $entity = $type[0] ?? 'Unknown';
        $identifier = str_replace('_', '', ucwords(implode('_', $type), '_'));

        /** @var class-string<Entity> $entity */
        $entity = sprintf('\Paddle\SDK\Notifications\Entities\%s', ucfirst($entity));

        if (! class_exists($entity) || ! in_array(Entity::class, class_implements($entity), true)) {
            throw new \UnexpectedValueException("Event type '{$identifier}' cannot be mapped to an object");
        }

        return $entity::from($data);
    }
}
