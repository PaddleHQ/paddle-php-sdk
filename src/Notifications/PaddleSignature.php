<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications;

final class PaddleSignature
{
    public const HEADER = 'Paddle-Signature';
    public const HASH_ALGORITHM_1 = 'h1';
    public const TIMESTAMP = 'ts';

    private function __construct(
        public readonly int $timestamp,
        public readonly array $hashes,
    ) {
    }

    /** @see https://developer.paddle.com/webhooks/signature-verification */
    public function verify(string $data, Secret ...$secrets): bool
    {
        foreach ($secrets as $secret) {
            foreach ($this->hashes as $hashAlgorithm => $possibleHashes) {
                $hash = match ($hashAlgorithm) {
                    self::HASH_ALGORITHM_1 => self::calculateHMAC("{$this->timestamp}:{$data}", $secret->key),
                    default => throw new \LogicException('Unknown hash algorithm ' . var_export($hashAlgorithm, true)),
                };

                foreach ($possibleHashes as $possibleHash) {
                    if (\hash_equals($hash, $possibleHash)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public static function calculateHMAC(string $data, string $key): string
    {
        return \hash_hmac('sha256', $data, $key);
    }

    public static function parse(string $header): self
    {
        $components = [
            self::TIMESTAMP => 0,
            'hashes' => [],
        ];

        foreach (\explode(';', $header) as $part) {
            if (\str_contains($part, '=')) {
                [$key, $value] = \explode('=', $part, 2);

                match ($key) {
                    self::TIMESTAMP => $components[self::TIMESTAMP] = (int) $value,
                    self::HASH_ALGORITHM_1 => $components['hashes'][self::HASH_ALGORITHM_1][] = $value,
                    default => throw new \LogicException('Unknown key ' . var_export($key, true)),
                };
            }
        }

        return new self(
            $components[self::TIMESTAMP],
            $components['hashes'],
        );
    }
}
