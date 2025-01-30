<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications\Entities;

/**
 * @internal
 */
final class EntityNameResolver
{
    public static function resolve(string $eventType): string
    {
        // Map specific event entity types.
        $eventEntityTypes = [
            'payment_method.deleted' => 'DeletedPaymentMethod',
        ];

        return $eventEntityTypes[$eventType] ?? self::resolveNameFromEventType($eventType);
    }

    public static function resolveFqn(string $eventType): string
    {
        $fqn = sprintf('\Paddle\SDK\Notifications\Entities\%s', self::resolve($eventType));

        return class_exists($fqn) ? $fqn : UndefinedEntity::class;
    }

    /**
     * @return class-string<Entity>
     */
    private static function resolveNameFromEventType(string $eventType): string
    {
        $type = explode('.', $eventType);

        return self::snakeToPascalCase($type[0] ?? 'Unknown');
    }

    private static function snakeToPascalCase(string $string): string
    {
        return str_replace('_', '', ucwords($string, '_'));
    }
}
