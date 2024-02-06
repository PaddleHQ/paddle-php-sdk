<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications;

final class Verifier
{
    public function __construct(
        private readonly int|null $maximumVariance = 5,
    ) {
    }

    public function verify(string $payload, string $signatureHeader, Secret ...$secrets): bool
    {
        $signature = PaddleSignature::parse($signatureHeader);

        if ($this->maximumVariance > 0 && \time() > $signature->timestamp + $this->maximumVariance) {
            return false;
        }

        return $signature->verify(
            $payload,
            ...$secrets,
        );
    }
}
