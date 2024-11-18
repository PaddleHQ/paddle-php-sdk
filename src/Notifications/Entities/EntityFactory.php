<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities;

class EntityFactory
{
    public static function create(string $eventType, array $data): Entity
    {
        // Map specific event entity types.
        $eventEntityTypes = [
            'payment_method.deleted' => DeletedPaymentMethod::class,
        ];

        $entity = $eventEntityTypes[$eventType] ?? self::resolveEntityClass($eventType);

        return $entity::from($data);
    }

    /**
     * @return class-string<Entity>
     */
    private static function resolveEntityClass(string $eventType): string
    {
        $type = explode('.', $eventType);
        $entity = self::snakeToPascalCase($type[0] ?? 'Unknown');
        $identifier = self::snakeToPascalCase(implode('_', $type));

        /** @var class-string<Entity> $entity */
        $entity = sprintf('\Paddle\SDK\Notifications\Entities\%s', $entity);
        if (! class_exists($entity)) {
            $entity = UndefinedEntity::class;
        }

        if (! class_exists($entity) || ! in_array(Entity::class, class_implements($entity), true)) {
            throw new \UnexpectedValueException("Event type '{$identifier}' cannot be mapped to an object");
        }

        return $entity;
    }

    private static function snakeToPascalCase(string $string): string
    {
        return str_replace('_', '', ucwords($string, '_'));
    }
}
