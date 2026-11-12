<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\ApiKeys;

use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;

/**
 * The API key whose rotations to list, get or create.
 *
 * A key can only manage its own rotations, so requests for a key are authenticated with that key's secret.
 */
final class RotatableApiKey
{
    private const SECRET_PATTERN = '/^pdl_\w+?_apikey_([a-z\d]{26})_/';

    private function __construct(
        public readonly string|null $id,
        #[\SensitiveParameter] private readonly string|null $secret,
    ) {
    }

    /**
     * The API key the client is authenticated with.
     */
    public static function current(): self
    {
        return new self(null, null);
    }

    /**
     * Another API key. Its ID is read from the secret, and its requests are authenticated with the secret instead of the client's API key.
     *
     * @throws InvalidArgumentException If the secret isn't an API key that can be rotated
     */
    public static function from(#[\SensitiveParameter] string $secret): self
    {
        $id = self::idFromSecret($secret) ?? throw new InvalidArgumentException('secret is not an API key that can be rotated');

        return new self($id, $secret);
    }

    public function isCurrent(): bool
    {
        return $this->secret === null;
    }

    /**
     * @internal
     */
    public function secret(): string|null
    {
        return $this->secret;
    }

    /**
     * @internal
     *
     * Returns null for keys without an ID in them, such as legacy API keys, which can't be rotated
     */
    public static function idFromSecret(#[\SensitiveParameter] string $secret): string|null
    {
        return preg_match(self::SECRET_PATTERN, $secret, $matches) === 1 ? "apikey_{$matches[1]}" : null;
    }

    /**
     * Keeps the secret out of var_dump() and print_r() output.
     *
     * @return array<string, mixed>
     */
    public function __debugInfo(): array
    {
        return [
            'id' => $this->id,
            'secret' => $this->secret === null ? null : '[REDACTED]',
        ];
    }
}
